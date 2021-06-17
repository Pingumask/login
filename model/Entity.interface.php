<?php

interface Entity{
    /**
     * Fetch an object from database by Id
     *
     * @param integer $id
     * @return self
     */
    public static function loadById(?int $id);

    /**
     * Updates an entity in database or creates it if it doesn't have an id yet
     *
     * @return void
     */
    public function save():void;
}