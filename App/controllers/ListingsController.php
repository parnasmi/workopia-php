<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;
use Framework\Guard;

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

    public function show(array $params) {
        $id = $params['id'] ?? '';


        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        if (!$listing) {
            ErrorController::notFound('Listing does no exist');
            return;
        }

        loadView('listings/show', [
            'listing' => $listing
        ]);
    }

    public function store(): void {
        $allowedFields = [
            'title',
            'description',
            'salary',
            'tags',
            'company',
            'address',
            'city',
            'state',
            'phone',
            'email',
            'requirements',
            'benefits',
            'tags',
            'user_id'
        ];
        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));
        $newListingData['user_id'] = Session::get('user')['id'];
        $newListingData = array_map('sanitize', $newListingData);

        $requiredFields = ['title', 'description', 'email', 'city', 'state', 'salary'];
        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!empty($errors)) {
            // Reload view with errors
            loadView('listings/create', [
                'errors' => $errors,
                'listing' => $newListingData
            ]);
        } else {
            $fields = [];
            $values = [];

            foreach ($newListingData as $field => $value) {
                $fields[] = $field;

                if ($value === '') {
                    $newListingData[$field] = null;
                }

                $values[] = ':' . $field;
            }

            $fields = implode(', ', $fields);
            $values = implode(', ', $values);

            $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";
            $this->db->query($query, $newListingData);
            Session::setFlashMessage('success_message', 'Listing has been successfully created.');
            redirect('/listings');
            exit;
        }
    }

    public function destroy(array $params): void {
        $id = $params['id'];

        $params = [
            "id" => $id
        ];


        $listing = $this->db->query('SELECT * FROM listings WHERE id=:id', $params)->fetch();


        if (!$listing) {
            ErrorController::notFound('Listing not found');
        }
        //be able to delete only own listings
        if (!Guard::isOwner($listing->user_id)) {
            Session::setFlashMessage('error_message', 'You are not authorized to delete this listing');
            redirect('/listings/' . $listing->id);
            exit;
        }

        $this->db->query('DELETE FROM listings WHERE id=:id', $params);
        Session::setFlashMessage('success_message', 'Listing has been successfully deleted.');
        redirect('/listings');
    }

    /**
     * Edit single listing
     *
     * @return void
     */

    public function edit(array $params) {
        $id = $params['id'] ?? '';


        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        if (!$listing) {
            ErrorController::notFound('Listing does no exist');
            return;
        }

        if (!Guard::isOwner($listing->user_id)) {
            Session::setFlashMessage('error_message', 'You are not authorized to update this listing');
            redirect('/listings/' . $listing->id);
            exit;
        }



        loadView('listings/edit', [
            'listing' => $listing
        ]);
    }

    /**
     * Update Listing 
     *
     * @param array $params
     * @return void
     */
    public function update(array $params): void {
        $id = $params['id'] ?? '';


        $params = [
            'id' => $id
        ];

        //get current listing till updated state
        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        if (!$listing) {
            ErrorController::notFound('Listing does no exist');
            return;
        }

        if (!Guard::isOwner($listing->user_id)) {
            Session::setFlashMessage('error_message', 'You are not authorized to update this listing');
            redirect('/listings/' . $listing->id);
            exit;
        }

        //list of fields to be updated
        $allowedFields = [
            'title',
            'description',
            'salary',
            'tags',
            'company',
            'address',
            'city',
            'state',
            'phone',
            'email',
            'requirements',
            'benefits',
            'tags',
        ];
        $updateValues = array_intersect_key($_POST, array_flip($allowedFields));

        //remove html chars
        $updateValues = array_map('sanitize', $updateValues);

        $requiredFields = ['title', 'description', 'email', 'city', 'state', 'salary'];
        $errors = [];

        //build error messages if unfilled fields of validation errors
        foreach ($requiredFields as $field) {
            if (empty($updateValues[$field]) || !Validation::string($updateValues[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        //handling validation errors
        if (!empty($errors)) {
            // Reload view with errors

            loadView('listings/edit', [
                'errors' => $errors,
                'listing' => $listing
            ]);
            exit;
        } else {
            //Submit to database
            $updateFields = [];

            foreach (array_keys($updateValues) as $field) {
                $updateFields[] = "{$field} = :{$field}";
            }
            //build fieldnames string to be updated
            $updateFields = implode(', ', $updateFields);

            //build SQL query on basis of  $updateFields
            $updateQuery = "UPDATE listings SET $updateFields WHERE id = :id";

            $updateValues['id'] = $id;

            //execute query
            $this->db->query($updateQuery, $updateValues);

            //set flash message
            $_SESSION['success_message'] = 'Listing updated';

            //redirect to single listing page
            redirect('/listings/' . $id);
        }
    }
}
