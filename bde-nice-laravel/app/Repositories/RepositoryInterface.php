<?php


namespace App\Repositories;


use Illuminate\Http\Request;

interface RepositoryInterface
{
    function findAll();
    function find($id);
    function store(Request $request);
    function update(Request $request);
    function destroy($id);
}
