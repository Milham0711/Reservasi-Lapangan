function showComingSoon() {
    alert("Fitur ini sedang dalam pengembangan.");
    return false;
}

// Generic slider initializer: finds every .slider on the page and wires controls, dots and autoplay.
(function () {
    const INTERVAL_MS = 4500;

    function initSlider(slider) {
        const slidesWrap = slider.querySelector(".slides");
        if (!slidesWrap) return;
        const slides = Array.from(slidesWrap.children);
        const prevBtn = slider.querySelector(".slider-btn.prev");
        const nextBtn = slider.querySelector(".slider-btn.next");
        // Prefer a sibling .slider-dots inside the same parent card
        const dotsContainer = slider.parentElement
            ? slider.parentElement.querySelector(".slider-dots")
            : null;
        let index = 0;
        let autoplayInterval = null;

        // compute exact slide width (in px) to ensure full-slide snapping
        let slideWidth = slides.length
            ? slides[0].getBoundingClientRect().width
            : 0;
        function updateDimensions() {
            slideWidth = slides.length
                ? slides[0].getBoundingClientRect().width
                : 0;
            // ensure we reposition to current index using new width
            slidesWrap.style.transition = "none";
            slidesWrap.style.transform = `translateX(-${index * slideWidth}px)`;
            // force reflow to allow transition after resize
            void slidesWrap.offsetWidth;
            slidesWrap.style.transition = "";
        }

        function goTo(i) {
            index = (i + slides.length) % slides.length;
            slidesWrap.style.transform = `translateX(-${index * slideWidth}px)`;
            // mark slides for accessibility
            slides.forEach((s, idx) => {
                s.setAttribute("aria-hidden", idx === index ? "false" : "true");
            });
            updateDots();
            // update live region for screen readers
            const announce = slider.parentElement
                ? slider.parentElement.querySelector(".sr-only")
                : null;
            const labelEl =
                slides[index].querySelector("h3") ||
                slides[index].querySelector(".slide-title");
            const labelText = labelEl
                ? labelEl.textContent.trim()
                : "Slide " + (index + 1);
            if (announce)
                announce.textContent = `${labelText}. Slide ${index + 1} dari ${
                    slides.length
                }`;
        }

        function next() {
            goTo(index + 1);
        }
        function prev() {
            goTo(index - 1);
        }

        function createDots() {
            if (!dotsContainer) return;
            dotsContainer.innerHTML = "";
            slides.forEach((_, i) => {
                const labelEl =
                    slides[i].querySelector("h3") ||
                    slides[i].querySelector(".slide-title");
                const label = labelEl
                    ? labelEl.textContent.trim()
                    : "Slide " + (i + 1);
                const btn = document.createElement("button");
                btn.setAttribute("role", "tab");
                btn.setAttribute("aria-selected", "false");
                btn.setAttribute(
                    "aria-controls",
                    slidesWrap.id || "heroSlides"
                );
                btn.setAttribute("aria-label", "Category " + label);
                const mark = document.createElement("span");
                mark.className = "dot-mark";
                const lbl = document.createElement("span");
                lbl.className = "dot-label";
                lbl.textContent = label;
                btn.appendChild(mark);
                btn.appendChild(lbl);
                btn.addEventListener("click", () => {
                    goTo(i);
                    resetAutoplay();
                    btn.focus();
                });
                dotsContainer.appendChild(btn);
            });
            updateDots();
        }

        function updateDots() {
            if (!dotsContainer) return;
            Array.from(dotsContainer.children).forEach((b, i) => {
                b.classList.toggle("active", i === index);
                // aria-selected/aria-current for accessibility
                if (i === index) {
                    b.setAttribute("aria-selected", "true");
                    b.setAttribute("aria-current", "true");
                } else {
                    b.setAttribute("aria-selected", "false");
                    b.removeAttribute("aria-current");
                }
            });
        }

        function startAutoplay() {
            if (autoplayInterval) clearInterval(autoplayInterval);
            autoplayInterval = setInterval(next, INTERVAL_MS);
        }
        function stopAutoplay() {
            if (autoplayInterval) {
                clearInterval(autoplayInterval);
                autoplayInterval = null;
            }
        }
        function resetAutoplay() {
            stopAutoplay();
            startAutoplay();
        }

        if (nextBtn)
            nextBtn.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                next();
                resetAutoplay();
            });
        if (prevBtn)
            prevBtn.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                prev();
                resetAutoplay();
            });

        slider.addEventListener("mouseenter", stopAutoplay);
        slider.addEventListener("mouseleave", startAutoplay);

        document.addEventListener("keydown", (e) => {
            if (e.key === "ArrowRight") {
                next();
                resetAutoplay();
            }
            if (e.key === "ArrowLeft") {
                prev();
                resetAutoplay();
            }
        });
        // respond to resize so slide snapping remains correct
        window.addEventListener("resize", function () {
            updateDimensions();
        });

        // touch / swipe support (simple horizontal swipe)
        let touchStartX = 0;
        let touchCurrentX = 0;
        let isTouching = false;

        slidesWrap.addEventListener(
            "touchstart",
            function (e) {
                if (!e.touches || e.touches.length === 0) return;
                isTouching = true;
                touchStartX = e.touches[0].clientX;
                touchCurrentX = touchStartX;
                slidesWrap.style.transition = "none";
                stopAutoplay();
            },
            { passive: true }
        );

        slidesWrap.addEventListener(
            "touchmove",
            function (e) {
                if (!isTouching || !e.touches || e.touches.length === 0) return;
                touchCurrentX = e.touches[0].clientX;
                const dx = touchCurrentX - touchStartX;
                slidesWrap.style.transform = `translateX(${
                    -index * slideWidth + dx
                }px)`;
            },
            { passive: true }
        );

        slidesWrap.addEventListener("touchend", function (e) {
            if (!isTouching) return;
            isTouching = false;
            const dx = touchCurrentX - touchStartX;
            // threshold to trigger swipe
            const threshold = Math.max(40, slideWidth * 0.15);
            if (dx > threshold) {
                prev();
            } else if (dx < -threshold) {
                next();
            } else {
                goTo(index);
            }
            resetAutoplay();
        });

        createDots();
        // ensure we measure sizes before positioning
        updateDimensions();
        if (slides.length <= 1) {
            if (prevBtn) prevBtn.style.display = "none";
            if (nextBtn) nextBtn.style.display = "none";
            if (dotsContainer) dotsContainer.style.display = "none";
        } else {
            startAutoplay();
        }

        goTo(0);
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".slider").forEach((s) => initSlider(s));
    });
})();

// small JS for user dropdown and mobile toggle
(function () {
    document.addEventListener("click", function (e) {
        const btn = document.getElementById("userMenuBtn");
        const menu = document.getElementById("userMenu");
        if (!btn || !menu) return;
        if (btn.contains(e.target)) {
            menu.style.display =
                menu.style.display === "block" ? "none" : "block";
            return;
        }
        if (!menu.contains(e.target)) {
            menu.style.display = "none";
        }
    });

    // mobile nav toggle (if you add items later)
    const navToggle = document.getElementById("navToggle");
    if (navToggle) {
        navToggle.style.display = "none"; // hide by default; show via CSS if needed
        navToggle.addEventListener("click", function () {
            // placeholder: could toggle a mobile menu
            alert("Menu toggle - not implemented");
        });
    }
})();
