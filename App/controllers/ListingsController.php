<?php

namespace App\Controllers;

use Framework\Database;

class ListingsController {
    protected $db;

    public function __construct() {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }


    /**
     * Show all listings in listings page
     *
     * @return void
     */

    public function index() {
        $listings = $this->db->query('SELECT * FROM listings')->fetchAll();

        loadView('listings/index', [
            'listings' => $listings
        ]);
    }

    /**
     * Show create listing page
     *
     * @return void
     */

    public function create() {
        loadView('listings/create');
    }
    /**
     * Show single listing
     *
     * @return void
     */

    public function show() {
        $id = $_GET['id'] ?? '';


        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        loadView('listings/show', [
            'listing' => $listing
        ]);
    }
}
