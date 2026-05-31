<?php

namespace App\Services;

use App\Models\Job;
use Illuminate\Support\Facades\Http;

class JobService
{
    protected string $apiUrl = 'https://api.baseplate.appetiserdev.tech/api/v1/jobs';

    /**
     * Fetch all paginated jobs from external API and upsert into DB.
     */
    public function fetchAndSync(): int
    {
        $page  = 1;
        $total = 0;

        do {
            $response = Http::get($this->apiUrl, [
                'page'    => $page,
                'include' => 'photos',
            ]);

            if ($response->failed()) {
                break;
            }

            $payload  = $response->json();
            $jobs     = $payload['data']              ?? [];
            $lastPage = $payload['meta']['last_page'] ?? 1;

            foreach ($jobs as $jobData) {
                $this->upsert($jobData);
                $total++;
            }

            $page++;
        } while ($page <= $lastPage);

        return $total;
    }

    /**
     * Insert or update a single job record.
     */
    public function upsert(array $data): Job
    {
        $known = [
            'id', 'category_id', 'subcategory_id', 'author_id',
            'title', 'slug', 'description', 'location', 'suburb',
            'price_offer', 'type', 'status', 'photos',
        ];

        return Job::updateOrCreate(
            ['external_id' => $data['id'] ?? null],
            [
                'category_id'    => $data['category_id']    ?? null,
                'subcategory_id' => $data['subcategory_id'] ?? null,
                'author_id'      => $data['author_id']      ?? null,
                'title'          => $data['title']          ?? null,
                'slug'           => $data['slug']           ?? null,
                'description'    => $data['description']    ?? null,
                'location'       => $data['location']       ?? null,
                'suburb'         => $data['suburb']         ?? null,
                'price_offer'    => $data['price_offer']    ?? null,
                'type'           => $data['type']           ?? null,
                'status'         => $data['status']         ?? null,
                'photos'         => $data['photos']         ?? null,
                'meta'           => collect($data)->except($known)->toArray(),
            ]
        );
    }
}
