@extends('layouts.material')
@section('title','Edit Supplier Detail')

@section('content')
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s10 m6 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-0">Edit Supplier Info</h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="#!">Manage Suppliers</a></li>
                            <li class="breadcrumb-item active">Edit Supplier Info</li>
                        </ol>
                    </div>
                    <div class="col s2 m6 l6">
                        <a class="btn waves-effect waves-light breadcrumbs-btn right" href="{{ route('suppliers') }}">
                            <i class="material-icons hide-on-med-and-up">people</i>
                            <span class="hide-on-small-onl">Back to Suppliers &nbsp;&nbsp;</span>
                            <i class="material-icons hide-on-small-onl right">people</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12">
            <div class="container">
                <div class="section section-data-tables">
                    <div class="card">
                        <div class="card-content">
                            <p class="caption mb-0">
                                Edit supplier below.
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div id="Form-advance" class="card card card-default scrollspy">
                                <div class="card-content">
                                    <h4 class="card-title">Supplier Info</h4>
                                    <form class="col s12" action="" method="post">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            <div class="input-field col m7 s12">
                                                <input id="supplier_name" name="name" value="{{ $supplier->name }}" type="text" required>
                                                <label for="supplier_name">Supplier Name *</label>
                                            </div>
                                            <div class="input-field col m5 s12">
                                                <input id="supplier_contact_name" name="contact_name" value="{{ $supplier->contact_name }}" type="text">
                                                <label for="supplier_contact_name">Contact Person Name</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col m6 s12">
                                                <input id="supplier_email" name="email" value="{{ $supplier->email }}" type="email">
                                                <label for="supplier_email">Supplier Email</label>
                                            </div>
                                            <div class="input-field col m6 s12">
                                                <input id="supplier_tel" name="tel" value="{{ $supplier->contact_tel }}" type="tel">
                                                <label for="supplier_tel">Supplier Contact Number</label>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <button class="btn cyan waves-effect waves-light right" type="submit">Update
                                                        <i class="material-icons right">send</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12">
            <div class="container">
                <!--Gradient Card-->
                <div id="cards-extended">

                    <div class="divider mt-2"></div>

                    <!--E-commerce Card-->
                    <div id="image-card" class="section">
                        <h4 class="header">Supplier Account Info</h4>
                        <p></p>
                        <div class="row">
                            <div class="col s12 m4">
                                <div class="card gradient-45deg-light-blue-cyan">
                                    <div class="card-content white-text center">
                                        <h6 class="card-title font-weight-400">Apple Watch</h6>
                                        <p>
                                            The Apple Watch, <br />
                                            all time witch will suit any time
                                        </p>
                                    </div>
                                    <div class="card-action border-non center">
                                        <a class="waves-effect waves-light btn gradient-45deg-red-pink box-shadow">$ 299/-</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m4">
                                <div class="card blue-grey darken-4">
                                    <div class="card-content white-text center">
                                        <span class="card-title blue-grey-text lighten-4 font-weight-400">The Asics Shoes</span>
                                        <p class="blue-grey-text lighten-4">
                                            Buy White Shoes for Men <br />
                                            online Huge selection of White Men
                                        </p>
                                    </div>
                                    <div class="card-action border-non center">
                                        <a class="waves-effect waves-light btn gradient-45deg-cyan-light-green black-text">$
                                            159/-</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m4">
                                <div class="card gradient-45deg-red-pink">
                                    <div class="card-content white-text center">
                                        <h6 class="card-title font-weight-400">iPhone</h6>
                                        <p>
                                            The Apple iPhone, <br />
                                            all time witch will suit any time
                                        </p>
                                    </div>
                                    <div class="card-action border-non center">
                                        <a class="waves-effect waves-light btn gradient-45deg-blue-indigo box-shadow">
                                            $ 299/-
                                        </a>
                                        <a class="waves-effect waves-light btn gradient-45deg-blue-indigo box-shadow">
                                            $ 299/-
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection

@section('page_scripts')
    <script src="{{ asset('js/scripts/form-layouts.js') }}" type="text/javascript"></script>
@endsection

