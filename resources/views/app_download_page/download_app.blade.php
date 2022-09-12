@extends('master')
@section('content')
    <script src="https://code.iconify.design/2/2.1.1/iconify.min.js"></script>
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 card-box">

    <!-- ======= download Section ======= -->
    <section class="hero-section" id="download_app_page_section">


                    <div class="row">
                        <div class="col-lg-8 text-center text-lg-start">
                            <h1 data-aos="fade-right">Download your app with QR code</h1>
                            {{-- <p class="mb-5" data-aos="fade-right" data-aos-delay="100">Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit.</p> --}}

{{--                            <button type="button" class="btn btn-lg btn-primary waves-effect waves-light">Block Button</button>--}}
                        </div>
                        <div class="col-lg-4 iphone-wrap">
                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(160)->generate($qr_url) !!}
                        </div>
                    </div>
                    <div class="row" id="wms-download-link-section">
                        <div class="col-md-4">
                            <span><i class="iconify" data-icon="noto:zebra"></i></span>
                            <h3 data-aos="fade-right">Download Zebra APP</h3>

                            <a href="{{$apps_links['data']['zebra_link']}}">Click to Download</a>
                        </div>
                        <div class="col-md-4">
                            <span><i class="fa fa-android" aria-hidden="true"></i></span>
                            <h3 data-aos="fade-right">Download Android APP</h3>

                            <a href="{{$apps_links['data']['android_link']}}" target="_blank">Click to Download</a>
                        </div>
                        <div class="col-md-4">
                            <span><i class="fa fa-apple" aria-hidden="true"></i></span>
                            <h3 data-aos="fade-right">Download IOS APP</h3>

                            <a href="{{$apps_links['data']['ios_link']}}" target="_blank">Click to Download</a>
                        </div>
                    </div>


    </section><!-- download section Hero -->

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
