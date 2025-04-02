@extends('layouts.app')
@section('content')
 <main>

    <section class="swiper-container js-swiper-slider swiper-number-pagination slideshow" data-settings='{
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": 1,
        "effect": "fade",
        "loop": true
      }'>
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="overflow-hidden position-relative h-100">
            <div class="slideshow-character position-absolute bottom-0 pos_right-center">
                <img loading="lazy" src="{{ asset('images/bg-menu/slide2.png') }}"
                    alt="Woman Fashion 1"
                    class="slideshow-character__img animate animate_fade animate_btt animate_delay-9"
                    style="width: 300px; height: auto; max-width: 100%;">
                <div class="character_markup type2">
                    <p class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                        Psychology Student
                    </p>
                </div>
            </div>

            <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
              <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                Bestlink Uniforms</h6>
              <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Psychology Uniform</h2>

              <a href="#"
                class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
                </a>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="overflow-hidden position-relative h-100">
            <div class="slideshow-character position-absolute bottom-0 pos_right-center">
                <img loading="lazy" src="{{ asset('images/bg-menu/slide3.png') }}"
                    alt="Woman Fashion 1"
                    class="slideshow-character__img animate animate_fade animate_btt animate_delay-9"
                    style="width: 500px; height: auto; max-width: 100%;">
                <div class="character_markup type2">
                    <p class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                        Information Technology
                    </p>
                </div>
            </div>
            <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
              <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                Bestlink Uniforms</h6>
              <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Information Technology <br>Uniform</h2>

              <a href="#"
                class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
                Now</a>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
            <div class="overflow-hidden position-relative h-100">
              <div class="slideshow-character position-absolute bottom-0 pos_right-center">
                  <img loading="lazy" src="{{ asset('images/bg-menu/slide4.png') }}"
                      alt="Woman Fashion 1"
                      class="slideshow-character__img animate animate_fade animate_btt animate_delay-9"
                      style="width: 500px; height: auto; max-width: 100%;">
                  <div class="character_markup type2">
                      <p class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                          Tourism Management
                      </p>
                  </div>
              </div>
              <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                  Bestlink Uniforms</h6>
                <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Tourism Management <br>Uniform</h2>

                <a href="#"
                  class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
                  Now</a>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="overflow-hidden position-relative h-100">
              <div class="slideshow-character position-absolute bottom-0 pos_right-center">
                  <img loading="lazy" src="{{ asset('images/bg-menu/slide5.png') }}"
                      alt="Woman Fashion 1"
                      class="slideshow-character__img animate animate_fade animate_btt animate_delay-9"
                      style="width: 500px; height: auto; max-width: 100%;">
                  <div class="character_markup type2">
                      <p class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                          Computer Engineering
                      </p>
                  </div>
              </div>
              <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                  Bestlink Uniforms</h6>
                <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Computer Engineering <br>Uniform</h2>

                <a href="#"
                  class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
                  Now</a>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="overflow-hidden position-relative h-100">
                <div class="slideshow-character position-absolute bottom-0 pos_right-center">
                    <img
                        loading="lazy"
                        src="{{ asset('images/bg-menu/slide7.png') }}"
                        alt="Woman Fashion 1"
                        class="slideshow-character__img animate animate_fade animate_btt animate_delay-9"
                        style="width: 1200px; height: 700px; max-width: 100%;">
                    <div class="character_markup type2">
                        <p class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                            Bachelor of Science in Business Administration
                        </p>
                    </div>
                </div>
                <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                    <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                        Bestlink Uniforms
                    </h6>
                    <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">
                        Bachelor of Science in Business <br>Administration
                    </h2>

                    <a href="#" class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">
                        Shop Now
                    </a>
                </div>
            </div>
        </div>

          <div class="swiper-slide">
            <div class="overflow-hidden position-relative h-100">
              <div class="slideshow-character position-absolute bottom-0 pos_right-center">
                  <img loading="lazy" src="{{ asset('images/bg-menu/slide6.png') }}"
                      alt="Woman Fashion 1"
                      class="slideshow-character__img animate animate_fade animate_btt animate_delay-9"
                      style="width: 500px; height: auto; max-width: 100%;">
                  <div class="character_markup type2">
                      <p class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                          Accountancy, Business Management
                      </p>
                  </div>
              </div>
              <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                  Bestlink Uniforms</h6>
                <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">ABM Uniform</h2>

                <a href="#"
                  class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
                  Now</a>
              </div>
            </div>
          </div>
        </div>
      <div class="container">
        <div
          class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5">
        </div>
      </div>
    </section>


    <section class="py-20 bg-gradient-to-br from-gray-100 to-gray-200">
        <div class="max-w-10xl mx-auto px-8">
          <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Bestlink College of the Philippines</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Providing quality education and exceptional opportunities for students</p>
          </div>

          <div class="flex flex-wrap justify-center gap-10">
            <!-- Students Box -->
            <div class="bg-white rounded-2xl shadow-md p-10 text-center transition-all duration-300 hover:-translate-y-4 hover:shadow-lg max-w-sm w-full relative overflow-hidden group">
              <div class="absolute inset-x-0 top-0 h-1 bg-blue-500 group-hover:h-full group-hover:opacity-5 transition-all duration-500"></div>
              <div class="w-20 h-20 bg-blue-500 bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-6 transition-transform duration-300 group-hover:scale-110">
                <i class='bx bx-user-plus text-4xl text-blue-500'></i>
              </div>
              <h3 class="text-2xl font-semibold text-gray-800 mb-2">30,000+ Students</h3>
              <p class="text-gray-500 leading-relaxed">Total of students enrolled in Bestlink College of the Philippines, learning and growing together in a vibrant academic community.</p>
            </div>

            <!-- Tuition Box -->
            <div class="bg-white rounded-2xl shadow-md p-10 text-center transition-all duration-300 hover:-translate-y-4 hover:shadow-lg max-w-sm w-full relative overflow-hidden group">
              <div class="absolute inset-x-0 top-0 h-1 bg-cyan-500 group-hover:h-full group-hover:opacity-5 transition-all duration-500"></div>
              <div class="w-20 h-20 bg-cyan-500 bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-6 transition-transform duration-300 group-hover:scale-110">
                <i class='bx bx-no-entry text-4xl text-cyan-500'></i>
              </div>
              <h3 class="text-2xl font-semibold text-gray-800 mb-2">PHP 0.00 Tuition</h3>
              <p class="text-gray-500 leading-relaxed">NO TUITION at Bestlink College of the Philippines and only pay 4,975 per semester. Making quality education accessible to all.</p>
            </div>

            <!-- K-12 Box -->
            <div class="bg-white rounded-2xl shadow-md p-10 text-center transition-all duration-300 hover:-translate-y-4 hover:shadow-lg max-w-sm w-full relative overflow-hidden group">
              <div class="absolute inset-x-0 top-0 h-1 bg-emerald-500 group-hover:h-full group-hover:opacity-5 transition-all duration-500"></div>
              <div class="w-20 h-20 bg-emerald-500 bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-6 transition-transform duration-300 group-hover:scale-110">
                <i class='bx bx-rocket text-4xl text-emerald-500'></i>
              </div>
              <h3 class="text-2xl font-semibold text-gray-800 mb-2">K to 12 Program Ready</h3>
              <p class="text-gray-500 leading-relaxed">Bestlink College of the Philippines offers K to 12 Program, preparing students for success in a competitive global environment.</p>
            </div>
          </div>
        </div>
      </section>
      <div class="flex flex-col md:flex-row items-center justify-center text-center md:text-left gap-8 py-12 px-4 md:px-8 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">

        <!-- Image Column (Centered) -->
        <div class="md:w-5/12 order-1 md:order-2 flex items-center justify-center">
            <div class="overflow-hidden rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <img
                    src="{{ asset('images/bg-menu/enroll.jpg') }}"
                    class="w-4/5 md:w-full h-auto object-cover transform hover:scale-105 transition-transform duration-500"
                    style="max-width: 700px; max-height: 500px;"
                    alt="Bestlink College campus">
            </div>
        </div>

        <!-- Content Column (Centered) -->
        <div class="md:w-7/12 order-2 md:order-1 flex flex-col items-center md:items-start text-center md:text-left space-y-4">
            <a href="" class="group">
                <h3 class="text-2xl md:text-3xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">
                    Enroll now at Bestlink College of the Philippines
                </h3>
            </a>

            <div class="space-y-3">
                <p class="text-lg font-medium italic text-blue-600">
                    "Be trained to be the best. Be linked to success."
                </p>

                <div class="space-y-2 text-gray-700">
                    <p class="font-medium">Enrollment is ongoing for First Semester Academic Year 2024-2025</p>
                    <p>COLLEGE Freshmen / Transferees / Returnees</p>
                    <p class="flex justify-center md:justify-start items-center">
                        <span class="font-medium">ADMISSION LINK:</span>
                        <a href="https://admission.bcp.edu.ph/" target="_blank"
                            class="ml-2 text-blue-600 hover:text-blue-800 hover:underline transition-colors duration-300">
                            https://admission.bcp.edu.ph/
                        </a>
                    </p>
                    <p>
                        <a href="https://www.facebook.com/hashtag/bcpupdate"
                            class="text-blue-500 hover:text-blue-700 transition-colors duration-300">
                            #bcpupdate
                        </a>
                    </p>
                </div>

                <div class="flex flex-col md:flex-row items-center md:items-start space-x-0 md:space-x-4 pt-2">
                    <a href="/news/enroll-now-at-bestlink-college-of-the-philippines"
                        class="inline-block px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-300 shadow-md hover:shadow-lg">
                        Read More
                    </a>

                    <p class="text-sm text-gray-500 italic mt-3 md:mt-0">
                        Posted by MIS Developer on January 21, 2025
                    </p>
                </div>
            </div>
        </div>
    </div>

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

      <section class="bg-gradient-to-r from-blue-500 to-indigo-600 py-16 text-white">
        <div class="container mx-auto px-6">
          <div class="text-center mb-12">
            <h2 class="text-4xl font-bold uppercase text-white">BCP News Update</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg">
              BCP News Update keeps our school community informed about our Business Continuity Plan (BCP), safety measures, emergency protocols, and strategies for uninterrupted learning.
            </p>
          </div>

          <!-- News Items -->
          <div class="grid md:grid-cols-2 gap-12">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden text-gray-800">
              <img src="{{ asset('images/bg-menu/campusministry.png')}}" class="w-full h-64 object-cover" alt="Campus Ministry">
              <div class="p-6">
                <h3 class="text-2xl font-semibold">Bestlink College of the Philippines - Campus Ministry</h3>
                <p class="mt-4 text-gray-600">BCP trains students to be self-motivated and self-directed individuals, guiding them towards success and active participation in society.</p>
                <ul class="mt-4 space-y-2">
                  <li class="flex items-center"><i class="bi bi-check text-blue-500 mr-2"></i> Be trained to be the  <strong>best</strong>.</li>
                  <li class="flex items-center"><i class="bi bi-check text-blue-500 mr-2"></i> Be  <strong>linked</strong> to success.</li>
                </ul>
              </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg overflow-hidden text-gray-800">
              <img src="{{ asset('images/bg-menu/advisory.jpg')}}" class="w-full h-64 object-cover" alt="Advisory">
              <div class="p-6">
                <a href="/news/advisory-no-001-0129-s2025" class="text-xl font-semibold hover:text-blue-500">Advisory No. 001-0129, s2025</a>
                <p class="mt-4 text-gray-600">All students and faculty are informed that classes will be ONLINE from January 30 to February 1 due to ongoing construction.</p>
                <a href="/news/advisory-no-001-0129-s2025" class="mt-4 inline-block text-blue-500 font-medium">Read More →</a>
                <p class="mt-2 text-sm text-gray-500">Posted by Social Media on January 29, 2025</p>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>



  </main>
@endsection
