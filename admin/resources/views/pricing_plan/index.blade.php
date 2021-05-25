@extends('layouts.app')
@section('title', "Pricing Plan")
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Pricing Plans</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Pricing Plans</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="jumbotron jumbotron-fluid">

            <div class="container">

                <div class="row">
                    <div class="col-sm-9">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fa fa-image"></i></span>

                            <div class="info-box-content">
                                <span> <b>Total Number of Pricing Plans:</b> {{$pricing_plans->count()}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-sm-3 mb-2">
                        <button type="button" class="btn btn-info btn-block" data-toggle="modal"
                                data-target="#pricingPlanCreateModal"><i class="fa fa-plus"></i> Add New
                            Pricing Plan
                        </button>
                    </div>
                </div>

                <div class="row">
                    @foreach($pricing_plans as $pricing_plan)
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body" style="height: 500px; overflow: scroll">
                                    <div class="position-relative p-3 bg-light" >
                                        <div class="ribbon-wrapper ribbon-xl">
                                            <div class="ribbon bg-danger text-xl">
                                                {{$pricing_plan->name}}
                                            </div>
                                        </div>
                                        @if($pricing_plan->discount > 0)
                                            Previous Price: <del class="text-danger">{{$pricing_plan->price}}</del>
                                            <br>
                                            Discount: {{$pricing_plan->discount}}%
                                            <br>
                                            Current Price: {{$pricing_plan->final_price}}
                                        @else
                                            Price: {{$pricing_plan->final_price}}
                                         @endif
                                      <div class="pt-3">
                                          <h5>Specifications</h5>
                                        {!! html_entity_decode($pricing_plan->description) !!}
                                      </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <a href="{{route('pricing_plans.edit', $pricing_plan->id)}}"
                                           class="btn btn-primary">Edit </a>
                                        <a href="#" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="modal fade" id="pricingPlanCreateModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create New Pricing Plan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="pricingPlanCreateForm" action="{{route('pricing_plans.store')}}"
                          method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="name">Pricing Plan Name</label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Enter Pricing Plan Name"
                                               name="name" id="name" autocomplete="off">
                                        @error('name') <span
                                            class="text-danger float-right">{{$errors->first('name') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number"
                                               class="form-control @error('price') is-invalid @enderror"
                                               placeholder="Enter Price of this plan"
                                               name="price" id="price" autocomplete="off"
                                               onkeyup="calculateFinalPrice()">
                                        @error('price') <span
                                            class="text-danger float-right">{{$errors->first('price') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="discount">Discount Percentage</label>
                                        <input type="number"
                                               class="form-control @error('discount') is-invalid @enderror"
                                               placeholder="Enter discount percentage if available"
                                               name="discount" id="discount" value="0" autocomplete="off"
                                               onkeyup="calculateFinalPrice()">
                                        @error('discount') <span
                                            class="text-danger float-right">{{$errors->first('discount') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="final_price">Final Price</label>
                                        <input type="number"
                                               class="form-control @error('final_price') is-invalid @enderror"
                                               placeholder="Enter Final Price"
                                               name="final_price" id="final_price" autocomplete="off"
                                               onkeyup="calculateDiscountPercentage()">
                                        @error('final_price') <span
                                            class="text-danger float-right">{{$errors->first('final_price') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description">Pricing Plan Description</label>
                                        <textarea name="description" id="description" rows="3"
                                                  class="textarea form-control"
                                                  placeholder="Write briefly about this pricing plan"></textarea>
                                        <div class="errorSummer float-right">
                                            <span class="msg-error error"></span>
                                        </div>
                                        @error('description') <span
                                            class="text-danger float-right">{{$errors->first('description') }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default float-right"
                                    data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-info float-right">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>


@endsection

@push('push-script')
    <script>

        $(document).ready(function () {
            $('.textarea').summernote({
                height: 125,
            });

            $('#pricingPlanCreateForm').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 70,
                    },
                    price: {
                        required: true,

                    },
                    discount: {
                        required: true,

                    },
                    final_price: {
                        required: true,

                    },

                },
                messages: {
                    name: {
                        required: "Please enter Pricing plan Name",
                        maxlength: "Pricing plan Name should be under 70 characters"
                    },
                    price: {
                        required: "Please enter price",

                    },

                    discount: {
                        required: "Please enter discount",

                    },

                    final_price: {
                        required: "Please enter final price",
                    },



                },

            });
            $(".note-editable").keyup(function () {
                $('.msg-error').text('');
                $('.msg-error').removeClass("error");
            });
            /*Summer Validation*/
            $('#pricingPlanCreateForm').submit(function (event) {
                if ($(".note-editable").text() != 0) {
                    $('.msg-error').text('');
                    $('.msg-error').removeClass("error");
                } else {
                    $('.msg-error').text("Please enter Pricing plan description");
                    event.preventDefault();
                    if (!$('.msg-error').hasClass("error")) {
                        $('.msg-error').addClass("error");
                        event.preventDefault();
                    }
                }
            });

        });

        function calculateFinalPrice() {
            let price = Number($('#price').val());
            let discount = Number($('#discount').val());
            if (price === "") {
                price = 0;
                discount = 0;
            }
            if (discount === "") {
                discount = 0;
            }
            let fractionOfPercent = discount / 100
            let discountPrice = price * fractionOfPercent
            let final_price = price - discountPrice

            $('#final_price').val(final_price.toFixed(2))
            $('#discount').val(discount)

        }

        function calculateDiscountPercentage() {

            let price = Number($('#price').val());
            let final_price = Number($('#final_price').val());

            if (price > 0)
            {
                let discountPercent = ((price - final_price) * 100) / price
                $('#discount').val(discountPercent)
            }else{
                $('#discount').val(0)
            }
        }


    </script>
@endpush

