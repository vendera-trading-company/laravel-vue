<?php

namespace VenderaTradingCompany\LaravelVue\Actions\Vue;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\AbstractPaginator;
use VenderaTradingCompany\PHPActions\Action;

class VueObject extends Action
{
    private $encodingOptions = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT;

    protected $secure = [
        'object',
        'encode'
    ];

    public function handle()
    {
        $object = $this->getData('object');
        $encode = $this->getData('encode', true);

        if ($object instanceof Model) {
            return [
                'object' => $this->parseToVue($this->exportObject($object), $encode),
            ];
        }

        if ($object instanceof AbstractPaginator) {
            $objects = $object->map(function ($item) {
                return $this->exportObject($item);
            });

            $data = [
                'data' => $objects,
                'current_page' => $object->currentPage(),
                'next_page_url' => $object->nextPageUrl(),
                'prev_page_url' => $object->previousPageUrl(),
                'total' => $object->total(),

            ];

            return [
                'object' => $this->parseToVue($data, $encode)
            ];
        }

        if ($object instanceof Collection) {
            $objects = $object->map(function ($item) {
                return $this->exportObject($item);
            });

            $data = [
                'data' => $objects,

            ];

            return [
                'object' => $this->parseToVue($data, $encode)
            ];
        }

        return [
            'object' => $this->parseToVue($this->exportObject($object), $encode),
        ];
    }

    private function exportObject(mixed $object)
    {
        if (is_numeric($object)) {
            return $object;
        }

        if (is_string($object)) {
            return $object;
        }

        if (is_bool($object)) {
            return $object;
        }

        if (method_exists($object, 'vue')) {
            return $object->vue();
        }

        if (method_exists($object, 'toArray')) {
            return $object->toArray();
        }

        return $object;
    }

    private function parseToVue($object, $encode)
    {
        if ($object == null) {
            return $object;
        }

        if (!$encode) {
            return $object;
        }

        return json_encode($object, $this->encodingOptions);
    }
}
