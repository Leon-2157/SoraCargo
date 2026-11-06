/**
* Template Name: Squadfree
* Template URL: https://bootstrapmade.com/squadfree-free-bootstrap-template-creative/
* Updated: Aug 07 2024 with Bootstrap v5.3.3
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

(function() {
  "use strict";

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   */
  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  /**
   * Mobile nav toggle
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavToggleBtn.classList.toggle('bi-list');
    mobileNavToggleBtn.classList.toggle('bi-x');
  }
  mobileNavToggleBtn.addEventListener('click', mobileNavToogle);

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navmenu a').forEach(navmenu => {
    navmenu.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });

  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

  /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

  /**
   * Initiate Pure Counter
   */
  new PureCounter();

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Init isotope layout and filters
   */
  document.querySelectorAll('.isotope-layout').forEach(function(isotopeItem) {
    let layout = isotopeItem.getAttribute('data-layout') ?? 'masonry';
    let filter = isotopeItem.getAttribute('data-default-filter') ?? '*';
    let sort = isotopeItem.getAttribute('data-sort') ?? 'original-order';

    let initIsotope;
    imagesLoaded(isotopeItem.querySelector('.isotope-container'), function() {
      initIsotope = new Isotope(isotopeItem.querySelector('.isotope-container'), {
        itemSelector: '.isotope-item',
        layoutMode: layout,
        filter: filter,
        sortBy: sort
      });
    });

    isotopeItem.querySelectorAll('.isotope-filters li').forEach(function(filters) {
      filters.addEventListener('click', function() {
        isotopeItem.querySelector('.isotope-filters .filter-active').classList.remove('filter-active');
        this.classList.add('filter-active');
        initIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        if (typeof aosInit === 'function') {
          aosInit();
        }
      }, false);
    });

  });

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Correct scrolling position upon page load for URLs containing hash links.
   */
  window.addEventListener('load', function(e) {
    if (window.location.hash) {
      if (document.querySelector(window.location.hash)) {
        setTimeout(() => {
          let section = document.querySelector(window.location.hash);
          let scrollMarginTop = getComputedStyle(section).scrollMarginTop;
          window.scrollTo({
            top: section.offsetTop - parseInt(scrollMarginTop),
            behavior: 'smooth'
          });
        }, 100);
      }
    }
  });

  /**
   * Navmenu Scrollspy
   */
  let navmenulinks = document.querySelectorAll('.navmenu a');

  function navmenuScrollspy() {
    navmenulinks.forEach(navmenulink => {
      if (!navmenulink.hash) return;
      let section = document.querySelector(navmenulink.hash);
      if (!section) return;
      let position = window.scrollY + 200;
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        document.querySelectorAll('.navmenu a.active').forEach(link => link.classList.remove('active'));
        navmenulink.classList.add('active');
      } else {
        navmenulink.classList.remove('active');
      }
    })
  }
  /**
   * SoraCargo Hero Widget Interactivity
   */
  const trackBtn = document.getElementById('btnTrackSubmit');
  const trackInput = document.getElementById('trackingInput');
  const trackResult = document.getElementById('trackingResult');

  if (trackBtn && trackInput && trackResult) {
    trackBtn.addEventListener('click', function() {
      const code = trackInput.value.trim().toUpperCase();
      if (!code) {
        alert('Silakan masukkan nomor resi, B/L, atau kontainer terlebih dahulu.');
        return;
      }

      // Simulate live radar query
      trackBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mencari...';
      trackBtn.disabled = true;

      setTimeout(() => {
        trackBtn.innerHTML = '<i class="bi bi-search"></i> Lacak';
        trackBtn.disabled = false;
        
        let vesselName = "KM Sora Nusantara (Voy. 042)";
        let route = "Tg. Priok (JKT) → Tg. Perak (SBY)";
        let position = "Laut Jawa (05°58'S 110°12'E)";
        let eta = "08 Nov 2026 - 16:00 WIB";
        let status = "Sedang Berlayar (In Transit)";

        if (code.includes("MSKU") || code.includes("8820")) {
          vesselName = "MV Meratus Kapuas (Voy. 118)";
          route = "Tg. Perak (SBY) → Belawan (MDN)";
          position = "Selat Bangka (02°24'S 105°45'E)";
          eta = "10 Nov 2026 - 09:30 WIB";
        } else if (code.includes("MKS")) {
          vesselName = "KM Samudera Sejahtera (Voy. 009)";
          route = "Tg. Priok (JKT) → Soekarno-Hatta (Makassar)";
          position = "Laut Flores (07°15'S 119°10'E)";
          eta = "11 Nov 2026 - 14:00 WITA";
        }

        trackResult.innerHTML = `
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge bg-success" style="font-size: 0.75rem;"><i class="bi bi-ship me-1"></i> ${status}</span>
            <span class="text-info fw-bold" style="font-size: 0.8rem;">Kecepatan: 14.5 Knots</span>
          </div>
          <div class="text-white fw-bold mb-1" style="font-size: 0.95rem;">${vesselName}</div>
          <div class="text-secondary small mb-2">Rute: ${route}</div>
          <div class="p-2 rounded mb-2" style="background: rgba(15, 23, 42, 0.7); font-size: 0.8rem; border: 1px solid rgba(255,255,255,0.06);">
            <div class="d-flex justify-content-between text-secondary mb-1">
              <span>Posisi Terakhir:</span>
              <span class="text-white">${position}</span>
            </div>
            <div class="d-flex justify-content-between text-secondary">
              <span>Estimasi Tiba (ETA):</span>
              <span class="text-warning fw-semibold">${eta}</span>
            </div>
          </div>
          <a href="http://customer.soracargo.local" class="btn-widget-action text-decoration-none">
            <i class="bi bi-radar"></i> Buka Detail Radar di Portal Customer
          </a>
        `;
      }, 500);
    });
  }

  // Rate calculator simulation
  const calcBtn = document.getElementById('btnCalcRate');
  if (calcBtn) {
    calcBtn.addEventListener('click', function() {
      const origin = document.getElementById('originPort').value;
      const dest = document.getElementById('destPort').value;
      const cargo = document.getElementById('cargoType').value;
      const priceEl = document.getElementById('ratePrice');
      const durationEl = document.getElementById('rateDuration');

      let basePrice = 8500000;
      let days = "± 2 - 3 Hari";

      if (origin === dest) {
        alert('Pelabuhan asal dan tujuan tidak boleh sama.');
        return;
      }

      if (cargo === '40ft') {
        basePrice = 15800000;
      } else if (cargo === 'lcl') {
        basePrice = 550000; // per CBM
      } else if (cargo === 'reefer') {
        basePrice = 19500000;
      } else if (cargo === 'barge') {
        basePrice = 45000000;
      }

      if (dest === 'SIN' || origin === 'SIN' || dest === 'MKS') {
        basePrice = Math.round(basePrice * 1.45);
        days = "± 4 - 6 Hari";
      }

      const formattedPrice = cargo === 'lcl' 
        ? "Rp " + basePrice.toLocaleString('id-ID') + " / CBM"
        : "Rp " + basePrice.toLocaleString('id-ID') + " / Box";

      if (priceEl) priceEl.innerText = formattedPrice;
      if (durationEl) durationEl.innerText = days + " Pelayaran";
    });
  }

})();