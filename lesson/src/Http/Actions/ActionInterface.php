<?php

namespace App\Http\Actions;


interface ActionInterface
{
    public function handle(Request $request): Response;
}