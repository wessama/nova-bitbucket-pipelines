<?php

namespace WessamA\NovaBitbucketPipelines\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Connects to Bitbucket and pulls the latest CI/CD pipelines results
 *
 * @author Wessam <wessam.ah@outlook.com>
 */
class PipelineController extends Controller
{
    private string $listPipelinesApi = 'repositories/{workspace}/{repo_slug}/pipelines/';
    private array $config;

    public function __construct()
    {
        $this->config = config('nova-bitbucket-pipelines');

        if (! $this->config || ! isset($this->config['app_password'])) {
            abort(Response::HTTP_BAD_REQUEST, 'BitBucket API config values are not set', ['Content-Type' => 'application/json']);
        }
    }

    public function __invoke(Request $request)
    {
        $resources = collect();

        $endpointUrl = $this->buildEndpointUrl($this->listPipelinesApi);

        try {
            $response = Http::withBasicAuth(
                $this->config['username'],
                $this->config['app_password']
            )->get(
                $this->config['api_url'] . '/'
                . $this->config['api_version'] . '/'
                . $endpointUrl
                . '?sort=-created_on'
            );

            if ($response->status() == Response::HTTP_OK) {
                $resources = $this->processResponse($response);
            }
        } catch (Exception $e) {
            Log::error('Unable to establish connection to BitBucket API: ' . $e->getMessage());
            abort(Response::HTTP_BAD_REQUEST, 'Could not fetch pipelines', ['Content-Type' => 'application/json']);
        }

        return [
            'resources' => $resources,
        ];
    }

    private function buildEndpointUrl(string $path): string
    {
        return str_replace(
            ['{workspace}', '{repo_slug}'],
            [
                $this->config['workspaces']['name'],
                $this->config['workspaces']['repo']['name'],
            ],
            $path
        );
    }

    private function processResponse($response)
    {
        $payload = $response->object();
        $pipelines = collect($payload->values ?? []);
        return $pipelines->unique('target.ref_name')->filter(function ($value) {
            return in_array(
                $value->target->ref_name,
                $this->config['workspaces']['repo']['refs']
            );
        })->map(function ($item) {
            $item->href = $item->repository->links->html->href . '/pipelines/results/' . $item->build_number;
            return $item;
        });
    }
}