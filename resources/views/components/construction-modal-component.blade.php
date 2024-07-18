<div class="modal" id="projectDetailModal">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <!-- Button trigger modal -->
            <div class="modal-body modal-fullscreen-body">
                <div class="heading-modal">
                    <button class="button-back-modal" onclick="closeModal()">
                        <img src="{{ asset('frontend/images/back.png') }}" alt="">
                    </button>
                    <button type="button" class="button-expand-modal outline-none" onclick="expandSlide()">
                        <img src="{{ asset('frontend/images/expand1.png') }}" alt="">
                    </button>
                    <button type="button" class="button-close-modal" data-bs-dismiss="modal"
                            onclick="closeModal()">
                        <img src="{{ asset('frontend/images/close-x.png') }}" alt="">
                    </button>
                </div>

                <div class="row project-content">
                    <div class="col-lg-8 col-md-12 align-items-center">
                        <div id="mainImageWrapper" class="main-image-wrapper">
                            <img src="" id="mainImage" alt="Main Image" class="main-image" onclick="expandSlide()">
                        </div>
                        <div class="row list-images-wrapper">
                            <div class="col-md-12" style="position: relative;">
                                <div class="list-images">
                                    <div>
                                        <img src="" alt="" class="slick-item">
                                    </div>
                                </div>
                                <div class="slick-controls">
                                    <button class="slick-prev">Previous</button>
                                    <button class="slick-next">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="project-detail">
                            <span class="d-block mb-3 title"></span>
                            <span class="d-block title area"></span>

                            <p class="description" style="text-align: justify">

                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
