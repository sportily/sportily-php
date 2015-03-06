<?php
namespace Sportily\Resources;

use Sportily\Requester;

abstract class Resource {

    public static function all($query = []) {
        return Requester::get(self::collectionUrl(), $query);
    }

    public static function retrieve($id) {
        return Requester::get(self::resourceUrl($id));
    }

    public static function create($data) {
        return Requester::post(self::collectionUrl(), $data);
    }

    public static function update($id, $data) {
        return Requester::put(self::resourceUrl($id), $data);
    }

    public static function delete($id) {
        return Requester::delete(self::resourceUrl($id));
    }

    protected static function collectionUrl() {
        return '/' . static::$class_url;
    }

    protected static function resourceUrl($id) {
        return self::collectionUrl() . '/' . $id;
    }

}
