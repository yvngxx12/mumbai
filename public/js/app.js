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

        function findThumbByImage(image) {
            return thumbs.filter(function (t) {
                return t.getAttribute("data-thumb-image") === image;
            })[0];
        }

        function selectColor(name) {
            var btn = colorBtns.filter(function (b) {
                return b.getAttribute("data-color-name") === name;
            })[0];

            if (!btn) {
                return;
            }

            var image = btn.getAttribute("data-color-image");

            colorBtns.forEach(function (b) {
                b.classList.toggle("is-selected", b === btn);
            });

            var thumb = findThumbByImage(image);

            thumbs.forEach(function (t) {
                t.classList.toggle("is-active", t === thumb);
            });

            if (mainImage && image) {
                mainImage.src = image;
            }

            if (selectedLabel) {
                selectedLabel.textContent = name;
            }
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
        var buyMessage = productRoot.querySelector("[data-buy-message]");

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

                buyMessage.textContent =
                    "Seleccionaste " +
                    (sizeName ? sizeName + " · " : "") +
                    (colorName ? colorName : "") +
                    " — El sistema de pagos estará disponible próximamente.";

                buyMessage.hidden = false;
            });
        }
    }
})();