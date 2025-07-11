<?php

declare(strict_types=1);

namespace OpenAI\Responses\Images;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @implements ResponseContract<array{created: int, data: array<int, array{url?: string, b64_json?: string, revised_prompt?: string}>}>
 */
final class CreateResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<array{created: int, data: array<int, array{url?: string, b64_json?: string, revised_prompt?: string}>}>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  array<int, CreateResponseData>  $data
     */
    private function __construct(
        public readonly int $created,
        public readonly array $data,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{created: int, data: array<int, array{url?: string, b64_json?: string, revised_prompt?: string}>}  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        $results = array_map(fn (array $result): CreateResponseData => CreateResponseData::from(
            $result
        ), $attributes['data']);

        return new self(
            $attributes['created'],
            $results,
            $meta,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'created' => $this->created,
            'data' => array_map(
                static fn (CreateResponseData $result): array => $result->toArray(),
                $this->data,
            ),
        ];
    }
}
