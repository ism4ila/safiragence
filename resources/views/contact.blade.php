@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 my-5">
                <h2>Contactez-Nous</h2>
                <p>Notre équipe est à votre disposition pour répondre à toutes vos questions et vous accompagner dans la réalisation de vos projets de voyage.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea name="message" id="message" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
            <div class="col-md-6">
                <h3>Informations de Contact</h3>
                <p><strong>Adresse :</strong> Immeuble SPC, avant carrefour aviation, Bertoua, ENIA</p>
                <p><strong>Téléphone :</strong> +237 222 24 30 84</p>
                <p><strong>Email :</strong> safir.agence.cameroun@gmail.com</p>
            </div>
        </div>
    </div>
@endsection