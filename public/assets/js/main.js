(function ($) {
    "use strict";

    var Medi = {
        init: function () {
            this.Basic.init();
        },

        Basic: {
            init: function () {
                this.Preloader();
                this.Tools();
                this.BackgroundImage();
                this.TabTable();
                this.Select();
                this.Editor();
                this.FilUpLoad();
                this.FileUploadName();
                this.PassShowHide();
                this.CopyToClipboard();
                this.PriceToggle();
                this.Slider();
                this.MobileMenu();
                this.CommonDataTable();
                this.SearchSticky();
            },
            SearchSticky: function () {
                jQuery(window).on("scroll", function () {
                    if (jQuery(window).scrollTop() > 250) {
                        jQuery(".header-search").addClass("sticky-on");
                    } else {
                        jQuery(".header-search").removeClass("sticky-on");
                    }
                });
            },
            MobileMenu: function () {
                $(".mobileMenu").on("click", function () {
                    $(".zSidebar").addClass("menuClose");
                });
                $(".zSidebar-overlay").on("click", function () {
                    $(".zSidebar").removeClass("menuClose");
                });
                // Menu arrow
                $(".zSidebar-menu li a").each(function () {
                    if (
                        $(this).next("div").find("ul.zSidebar-submenu li")
                            .length > 0
                    ) {
                        $(this).addClass("has-subMenu-arrow");
                    }
                });
            },
            Preloader: function () {
                $("#preloader-status").fadeOut();
                $("#preloader").delay(350).fadeOut("slow");
                $("body").delay(350);
            },
            Tools: function () {
                // Tooltips
                const tooltipTriggerList = document.querySelectorAll(
                    '[data-bs-toggle="tooltip"]'
                );
                const tooltipList = [...tooltipTriggerList].map(
                    (tooltipTriggerEl) =>
                        new bootstrap.Tooltip(tooltipTriggerEl)
                );

                // Sidebar active
                $(document).ready(function () {
                    $(".admin-section-left .item").each(function () {
                        const collapseDiv = $(this).find(".collapse");
                        const toggleButton = $(this).find(".leftSidebar-btn");
                        const activeLink = $(this).find(
                            ".leftSidebar-content a.content.active"
                        );

                        if (activeLink.length) {
                            collapseDiv.addClass("show");
                            toggleButton.removeClass("collapsed");
                            toggleButton.attr("aria-expanded", "true");
                        } else {
                            collapseDiv.removeClass("show");
                            toggleButton.addClass("collapsed");
                            toggleButton.attr("aria-expanded", "false");
                        }
                    });
                });
            },
            BackgroundImage: function () {
                $("[data-background]").each(function () {
                    $(this).css(
                        "background-image",
                        "url(" + $(this).attr("data-background") + ")"
                    );
                });
            },
            TabTable: function () {
                $(document).on(
                    "shown.bs.tab",
                    'button[data-bs-toggle="tab"]',
                    function (event) {
                        $($.fn.dataTable.tables(true))
                            .DataTable()
                            .responsive.recalc();
                        $($.fn.dataTable.tables(true)).css("width", "100%");
                        $($.fn.dataTable.tables(true))
                            .DataTable()
                            .columns.adjust()
                            .draw();
                    }
                );
            },
            Select: function () {
                // when need select with search field
                $(".sf-select").select2({
                    dropdownCssClass: "sf-select-dropdown",
                    selectionCssClass: "sf-select-section",
                });
                // when don't need search field but can't use in modal
                $(".sf-select-two").select2({
                    dropdownCssClass: "sf-select-dropdown",
                    selectionCssClass: "sf-select-section",
                    minimumResultsForSearch: -1,
                    placeholder: {
                        text: "Select an option",
                    },
                });
                // when don't need search field and can use in modal
                $(".sf-select-without-search").niceSelect();
                // when need search in modal
                $(".sf-select-modal").select2({
                    dropdownCssClass: "sf-select-dropdown",
                    selectionCssClass: "sf-select-section",
                    dropdownParent: $(".modal"),
                });
            },
            Editor: function () {
                $(".summernoteOne").summernote({
                    placeholder: "Write something here....",
                    tabsize: 2,
                    minHeight: 183,
                    toolbar: [
                        ["font", ["bold", "italic", "underline"]],
                        ["para", ["ul", "ol", "paragraph"]],
                    ],
                });
            },
            FilUpLoad: function () {
                // File attachment
                const dt = new DataTransfer();

                $("#mAttachment,#mAttachment1").on("change", function (e) {
                    for (var i = 0; i < this.files.length; i++) {
                        let fileBloc = $("<span/>", { class: "file-block" }),
                            fileName = $("<p/>", {
                                class: "name",
                                text: this.files.item(i).name,
                            });
                        fileBloc
                            .append(
                                '<span class="file-icon"><i class="fa-solid fa-file"></i></span>'
                            )
                            .append(fileName)
                            .append(
                                '<span class="file-delete"><i class="fa-solid fa-xmark"></i></span>'
                            );
                        $("#filesList > #files-names").append(fileBloc);
                    }

                    for (let file of this.files) {
                        dt.items.add(file);
                    }

                    this.files = dt.files;

                    $("span.file-delete").on("click",function () {
                        let name = $(this).next("span.name").text();

                        $(this).parent().remove();
                        for (let i = 0; i < dt.items.length; i++) {
                            if (name === dt.items[i].getAsFile().name) {
                                dt.items.remove(i);
                                continue;
                            }
                        }
                    });
                });
            },
            FileUploadName: function () {
                $(document).ready(function () {
                    $(document).on(
                        "change input",
                        ".fileUploadInput",
                        function () {
                            var fileName =
                                $(this).prop("files").length > 1
                                    ? $(this)[0].files.length +
                                      " files selected"
                                    : $(this).val().split("\\").pop();
                            $(this)
                                .closest(".file-upload-one")
                                .find(".fileName")
                                .text(fileName || "Choose Image to upload");
                        }
                    );
                });
            },
            PassShowHide: function () {
                $(".toggle-password").on("click", function () {
                    $(this).toggleClass("fa-eye fa-eye-slash");
                    var input = $(this).closest(".passShowHide").find("input");
                    if (input.attr("type") === "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });
            },
            CopyToClipboard: function () {
                $(document).ready(function () {
                    $(".copyTextBtn").on("click", function () {
                        const text = $("#copyText").text();
                        const tempInput = $("<input>");
                        $("body").append(tempInput);
                        tempInput.val(text).select();
                        document.execCommand("copy");
                        tempInput.remove();
                    });
                });
            },
            PriceToggle: function () {
                $("#zPrice-plan-switch").on("click", function () {
                    $(".zPrice-plan-monthly").toggleClass("d-none");
                    $(".zPrice-plan-yearly").toggleClass("d-none");
                });
            },
            Slider: function () {
                // People Observation slider
                var swiper = new Swiper(".peopleObservationSlider", {
                    slidesPerView: 1,
                    spaceBetween: 24,
                    autoplay: true,
                    // loop: true,
                    // centeredSlides: true,
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 1,
                        },
                        768: {
                            slidesPerView: 2,
                        },
                        1024: {
                            slidesPerView: 3,
                        },
                    },
                });
                // Brand slider
                var swiperAutoSlide = new Swiper(".autoImageslider", {
                    slidesPerView: 2,
                    spaceBetween: 24,
                    mousewheel: false,
                    grabCursor: false,
                    loop: true,
                    speed: 3000,
                    autoplay: {
                        delay: 0,
                    },
                    freeMode: true,
                    breakpoints: {
                        1024: {
                            slidesPerView: 5,
                            spaceBetween: 40,
                        },
                        576: {
                            slidesPerView: 3,
                            spaceBetween: 24,
                        },
                    },
                });
            },
            CommonDataTable: function () {
                $(".commonDataTable").DataTable({
                    pageLength: 10,
                    ordering: false,
                    processing: true,
                    responsive: true,
                    language: {
                        paginate: {
                            previous:
                                "<span class='iconify' data-icon='material-symbols:chevron-left-rounded'></span>",
                            next: "<span class='iconify' data-icon='material-symbols:chevron-right-rounded'></span>",
                        },
                        searchPlaceholder: "Search",
                        search: "",
                    },
                    dom: '<>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi adminTablePagi"p>>>><"clear">',
                });
                $(".commonDataTableWithOutPagination").DataTable({
                    pageLength: 50,
                    ordering: false,
                    processing: true,
                    responsive: true,
                    language: {
                        paginate: {
                            previous:
                                "<span class='iconify' data-icon='material-symbols:chevron-left-rounded'></span>",
                            next: "<span class='iconify' data-icon='material-symbols:chevron-right-rounded'></span>",
                        },
                        searchPlaceholder: "Search",
                        search: "",
                    },
                    dom: "",
                });
            },
        },
    };
    jQuery(document).ready(function () {
        Medi.init();
    });
})(jQuery);
