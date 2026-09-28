(function () {
    "use strict";

    function findAll(selector) {
        var scope = this && this.querySelectorAll ? this : document;
        return Array.prototype.slice.call(scope.querySelectorAll(selector));
    }

    /* ------------------------------------------------
       Producto: cambio de imagen según el color
       ------------------------------------------------ */
    var productRoot = document.querySelector("[data-product-root]");

    if (productRoot) {
        var colorBtns = findAll("[data-color-name]");
        var thumbs = findAll("[data-thumb-color]");
        var mainImage = productRoot.querySelector("[data-gallery-main]");
        var selectedLabel = productRoot.querySelector("[data-selected-color]");
        var backButton = productRoot.querySelector("[data-view-back]");
        var backLabel = productRoot.querySelector("[data-view-back-label]");
        var currentName = null;
        var showingBack = false;

        function findThumbByImage(image) {
            return thumbs.filter(function (t) {
                return t.getAttribute("data-thumb-image") === image;
            })[0];
        }

        function showSide() {
            var btn = colorBtns.filter(function (b) {
                return b.getAttribute("data-color-name") === currentName;
            })[0];

            if (!btn) {
                return;
            }

            var front = btn.getAttribute("data-color-image");
            var back = btn.getAttribute("data-color-back") || null;

            if (mainImage) {
                mainImage.src = showingBack && back ? back : front;
            }

            if (backButton) {
                backButton.hidden = !back;

                if (backLabel) {
                    backLabel.textContent = showingBack ? "Ver parte delantera" : "Ver parte trasera";
                }
            }
        }

        function selectColor(name) {
            var btn = colorBtns.filter(function (b) {
                return b.getAttribute("data-color-name") === name;
            })[0];

            if (!btn) {
                return;
            }

            currentName = name;
            showingBack = false;

            colorBtns.forEach(function (b) {
                b.classList.toggle("is-selected", b === btn);
            });

            var thumb = findThumbByImage(btn.getAttribute("data-color-image"));

            thumbs.forEach(function (t) {
                t.classList.toggle("is-active", t === thumb);
            });

            if (selectedLabel) {
                selectedLabel.textContent = name;
            }

            showSide();
        }

        colorBtns.forEach(function (btn) {
            btn.addEventListener("click", function () {
                selectColor(btn.getAttribute("data-color-name"));
            });
        });

        thumbs.forEach(function (thumb) {
            thumb.addEventListener("click", function () {
                selectColor(thumb.getAttribute("data-thumb-color"));
            });
        });

        if (backButton) {
            backButton.addEventListener("click", function () {
                showingBack = !showingBack;
                showSide();
            });
        }

        if (colorBtns.length) {
            selectColor(colorBtns[0].getAttribute("data-color-name"));
        }

        /* ----------------------------------------------
           Selector de talle
           ---------------------------------------------- */
        var sizeSelector = productRoot.querySelector("[data-size-selector]");

        if (sizeSelector) {
            var sizeBtns = findAll.call(productRoot, ".size-btn");

            sizeBtns.forEach(function (btn) {
                btn.addEventListener("click", function () {
                    sizeBtns.forEach(function (b) {
                        b.classList.remove("is-selected");
                    });
                    btn.classList.add("is-selected");
                });
            });
        }

        /* ----------------------------------------------
           Comprar
           ---------------------------------------------- */
        var buyButton = productRoot.querySelector("[data-buy-button]");

        if (buyButton) {
            buyButton.addEventListener("click", function () {
                var selectedColor = colorBtns.filter(function (b) {
                    return b.classList.contains("is-selected");
                })[0];

                var selectedSize = sizeBtns && sizeBtns.filter(function (b) {
                    return b.classList.contains("is-selected");
                })[0];

                var colorName = selectedColor ? selectedColor.getAttribute("data-color-name") : "";
                var sizeName = selectedSize ? selectedSize.value : "";
                var slug = buyButton.getAttribute("data-product-slug") || "";

                window.location.href =
                    "/comprar/" + encodeURIComponent(slug) +
                    "?color=" + encodeURIComponent(colorName) +
                    "&size=" + encodeURIComponent(sizeName);
            });
        }
    }
})();