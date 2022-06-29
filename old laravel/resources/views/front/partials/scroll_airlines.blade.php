<!-- Slider main container -->
<div class="swiper-container">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <!-- Slides -->

        @foreach($airlines as $item)

        <div class="swiper-slide"><img src="images/{{$item->image}}"> </div>

            @endforeach

    </div>

</div>
