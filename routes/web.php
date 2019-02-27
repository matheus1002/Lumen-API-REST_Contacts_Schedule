<?php

$router->get("/api/contacts", "ContactsController@getAll");

$router->group(['prefix' => "/api/contact"], function() use ($router) {
    $router->get("/{id}", "ContactsController@get");
    $router->post("/", "ContactsController@store");
    $router->put("/{id}", "ContactsController@update");
    $router->delete("/{id}", "ContactsController@destroy");
});
