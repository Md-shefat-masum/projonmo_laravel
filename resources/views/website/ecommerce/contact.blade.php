@extends('website.ecommerce.layouts.ecommerce')
@section('content')

    <section class="py-2 my-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Contact Form</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('website_sumbit_contact') }}" method="POST" @submit.prevent="sumbit_contact()" id="contact_form">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea name="message" id="message" class="form-control" style="min-height:120px;"></textarea>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-secondary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

