@extends('layouts.app')

@section('title', 'Daftar Tugas')

@section('page-title', 'Daftar Tugas')

@section('content')
<div class="container">
    <h1 class="py-3">Daftar Tugas</h1>
    <div class="row my-3">
        <div class="col-10 mx-auto">
            <div class="card shadow p-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h4>Interaksi Manusia Komputer</h4>
                            <p>High Fidelity Prototype</p>
                        </div>
                        <div class="col my-auto">
                            <p>21 april 2025</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-3">
        <div class="col-10 mx-auto">
            <div class="card shadow p-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h4>Pemrograman Web</h4>
                            <p>UAS</p>
                        </div>
                        <div class="col my-auto">
                            <p>13 Juli 2025</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection