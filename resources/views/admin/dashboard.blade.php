@extends('layouts.adminlayoutVue')
@section('content')

<h3>Dashboard</h3>
<script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.0/dist/index.bundle.min.js"></script>
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h6 font-weight-bold text-primary text-uppercase mb-1">
                            Balance</div>
                        <hr/>
                        <div class="h3 mb-0 font-weight-bold text-gray-800">{{$user_balance->amount}}</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
</div>
<div class="row">
    <div class="col-md-8 overflow-auto">
        <App></App>
    </div>
    <div class="col-md-4 overflow-auto pt-4 ">
        <div class="card border-right-primary shadow h-100 py-4">
            <div class="card-body">
                <img src='{{asset("media/photos/photo29.png")}}' class="img" style="width: 100%">
            </div>
        </div>
    </div>
</div>

<!-- <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet"> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.0/dist/index.bundle.min.js"></script> -->
<script>
    
    // import Lightbox from 'bs5-lightbox';

    const options = {
        keyboard: true,
        size: 'fullscreen',
        constrain: true,
        gallery: true
    };

    document.querySelectorAll('.my-lightbox-toggle').forEach((el) => el.addEventListener('click', (e) => {
        e.preventDefault();
        const lightbox = new Lightbox(el, options);
        lightbox.show();
    }));
</script>

<script>
    // Open the Modal
    function openModal() {
      document.getElementById("myModal").style.display = "block";
    }

    // Close the Modal
    function closeModal() {
      document.getElementById("myModal").style.display = "none";
    }

    var slideIndex = 1;
    showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
      showSlides(slideIndex += n);
    }

    // Thumbnail image controls
    function currentSlide(n) {
      showSlides(slideIndex = n);
    }

    function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("demo");
      var captionText = document.getElementById("caption");
      if (n > slides.length) {slideIndex = 1}
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";
      dots[slideIndex-1].className += " active";
      captionText.innerHTML = dots[slideIndex-1].alt;
    }
</script>
@endsection