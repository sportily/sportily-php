<?php

abstract class SportilyApiResource {

    public static function all($query = []) {
        return SportilyRequester::get(self::collectionUrl(), $query);
    }

    public static function retrieve($id) {
        return SportilyRequester::get(self::resourceUrl($id));
    }

    public static function create($data) {
        return SportilyRequester::post(self::collectionUrl(), $data);
    }

    public static function update($id, $data) {
        return SportilyRequester::put(self::resourceUrl($id), $data);
    }

    public static function delete($id) {
        return SportilyRequester::delete(self::resourceUrl($id));
    }

    protected static function collectionUrl() {
        return '/' . static::$class_url;
    }

    protected static function resourceUrl($id) {
        return self::collectionUrl() . '/' . $id;
    }

}
