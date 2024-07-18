<div class="modal fade" id="fullScreenModal" tabindex="-1" aria-labelledby="fullScreenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-fullscreen-slider">
        <div class="modal-content">
            <div class="modal-fullscreen-body" style="padding: 0">
                <div class="row project-content">
                    <button type="button" class="button-close-modal-fullscreen" onclick="exitFullScreen()">
                        <img src="{{ asset('frontend/images/close-x.png') }}" alt="">
                    </button>
                    <button class="button-collapse-modal-screen" onclick="exitFullScreen()">
                        <img src="{{ asset('frontend/images/collapse1.png') }}" alt="">
                    </button>
                    <div class="col-md-12 align-items-center">
                        <div id="projectSlider" class="slider-image carousel slide carousel-fade"
                             data-bs-interval="false">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="" onclick="expandSlide()"
                                         class="project-detail-image d-block" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="" onclick="expandSlide()"
                                         class="project-detail-image d-block" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#projectSlider"
                                    data-bs-slide="prev">
                                <!-- <span class="carousel-control-next-icon" aria-hidden="true"></span> -->
                                <span class=""><i class="fa-solid fa-chevron-left"></i></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#projectSlider"
                                    data-bs-slide="next">
                                <!-- <span class="carousel-control-next-icon" aria-hidden="true"></span> -->
                                <span class=""><i class="fa-solid fa-chevron-right"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
