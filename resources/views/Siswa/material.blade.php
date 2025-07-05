@extends('layouts.app')

@section('title', 'Daftar Materi')

@section('page-title', 'Daftar Materi')

@section('content')
<div class="container">
    <h1 class="py-3">Daftar Materi</h1>
    <div class="row my-3">
        <div class="col-10 mx-auto">
            <div class="card shadow-sm">
                <a href="#" class="btn btn-light text-start w-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h4>Interaksi Manusia Komputer</h4>
                                <p>High Fidelity Prototype</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row my-3">
        <div class="col-10 mx-auto">
            <div class="card shadow-sm">
                <a href="#" class="btn btn-light text-start w-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h4>Pemrograman Web</h4>
                                <p>CRUD</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection