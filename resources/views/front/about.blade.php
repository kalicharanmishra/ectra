@extends('front.layouts.app')



@section('content')

<!-- ============================================================== -->

<section style="background: #FFFBEB ;">	

	<div >

		<div class="container">

			<div class="row">

				<div class="col-lg-12 col-md-12">



					<div class="breadcrumbs-wrap">


						<nav class="transparent">

							<ol class="breadcrumbb">

								<li class="breadcrumb-item"><a href="/">Home</a></li>
								<li class="breadcrumb-item"><a href="/">Important links</a></li>

								<li class="breadcrumb-item theme-cl" aria-current="page">About us
								</li>

							</ol>

						</nav>

					</div>



				</div>

			</div>

		</div>

	</div>

	

	<!-- ============================ About Detail ================================== -->
	<div class="about_top_section">
		<section >

            <div class="container">

                <div class="row">

                    <div class="col-lg-12 col-md-12">
                        <div>

                            <h1 class="text-center" style="color: #a30a0a;">About Us</h1>
                        </div>



                    </div>

                </div>

            </div>

        </section>

		<div>

			<div class="container">

				<div class="row align-items-center justify-content-between about_text_center">

					<div class=" col-12 m-auto">

						<div class="lmp_caption">
							{{-- <h2 class="mb-3">About Us</h2> --}}

							<p>We are hobby enthusiasts who want to change the way people look at hobbies. 
								We want this platform to provide an opportunity to people of ALL ages, looking
								at learning something new. We have  courses ranging from short term ones (which 
								can be completed in a day or two, over a weekend) to longer duration ones. 
							</p>
							<p>              Basically, Etcetra has courses for everybody in the family, age no bar !!! 
							</p>
							<p>Welcome to the exciting and enriching world of Etcetra !!</p>
							
						</div>

					</div>
				</div>

			</div>

		</div>
	</div>
	<!-- ============================ About Detail ================================== -->

	

	

	<div class="clearfix"></div>

	<!-- ============================ partner End ================================== -->

	



	{{-- founder section --}}
	<section class="full_height_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 full_width_section_heading">
					<h2>Founder</h2>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<div class="full_width_section_img_side">
						<img class="img-fluid" src="{{url('/front/assets/img/mohita_pant_bhaduri.jpeg')}}" height="150" width="150" alt="" >
						<!-- <img src="{{URL::asset('img/mohita_pant_bhaduri.jpeg')}}" alt="profile Pic" height="200" width="200"> -->
						<div class="fouder_names_div">
							<h3>Mohita Pant Bhaduri</h3>
							<p>MBA</p>
						</div>
					</div>
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 full_width_section_content_side">
					<div>
						<p>
							Coming from a family of educators, I too always wanted to contribute to the field of education, but I was sure that I did not want it to be related to studies, because for me, the extra curricular was always more interesting than the curricular. 

						</p>
						<p>
							As life would have it, I ended up being a banker for 17 of the 21 years that I worked in the corporate world. Apart from being a banker, which I did for a living, I was always interested in the world of advertisements and films and had nurtured this urge to learn film-making, "sometime in the near future". That " future" was never "near enough" and I could never gather enough guts to give up the comforts of a corporate life and  start perusing my passion.  So, the day I clocked 20 years of working life, I quit my job and joined a short course in film-making. 

						</p>
						<p>
							Having tick-marked a big item off my bucket list, I decided to do something for others, who too want to pursue their passions, but have either not found the opportune time or the platform to nurture their creative pursuits. Etcetra is my attempt to bring all kinds of learning possibilities under the sun (of course, other than studies !!!), on a single platform for people of all ages, gender and stages in life.

						</p>
					</div>
				</div>
			</div>
		</div>
	</section>



	{{-- Mentor 1 section --}}
	<section class="full_height_section light_bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12  full_width_section_heading">
					<h2>Mentor</h2>
				</div>
				
				<div class="col-lg-8 col-md-8 col-sm-12 order-2 order-lg-1  full_width_section_content_side">
					<div>
						<p>Mrs. Shobha Pant - started her career as a teacher and went on to become the Principal and then the District Inspectress of girls’ schools where she was in-charge of all the girls' schools in Varanasi district. At the time of her retirement, she was the Assistant Director in the UP - state education department, wherein she was the in-charge of all the education projects funded by the World Bank in Varanasi district. Throughout her own school, college and working life, she has been a great propounder of the importance of extra-curricular activities. Her interest in "everything" was so profound that she forced me, her daughter, to take part in every competition that was announced in school, even though we both might have known nothing about it at the time of registering my name for the competition. Her funda was simple - "we don’t know it yet, no issues, we will find out and learn". And mind you, I was growing up in the 1990s when we did not have the power of the internet to teach us things. She would read about it or ask people who knew better, somehow ensuring that I was ready for the competition. Today, I find myself exactly doing the same and pushing my kids to participate in everything that is a part of Etcetra, Etcetra, Etcetra! She has been my biggest motivation behind Etcetra !!! .
						</p>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 order-1 order-lg-2 ">
					<div class="full_width_section_img_side">
						<img class="img-fluid" src="{{url('/front/assets/img/shobha_pant.jpeg')}}" alt="" height="150" width="150"  >
						<div class="fouder_names_div">
							<h3>Shobha Pant</h3>
							<p>M.Sc., B. Ed</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	{{-- Mentor  section --}}
	<section class="full_height_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 full_width_section_heading">
					<h2>Mentor</h2>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<div class="full_width_section_img_side">
						<img class="img-fluid Mentor" src="{{url('/front/assets/img/devesh_chandra_pant.jpeg')}}" height="150" width="150" alt="" >
						<div class="fouder_names_div">
							<h3>Dr. Devesh Chandra Pant</h3>
							<p>M.Sc., P.HD</p>
						</div>
					</div>
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 full_width_section_content_side">
					<div>
						<p class="mt-2">Dr. Devesh Chandra Pant - Retired as a Professor from Banaras Hindu University, Varanasi. A very well-read person, he keeps himself abreast of what is happening in the world around him, not only by digital sources, but by subscribing to and religiously reading 3 newspapers from cover to cover on an everyday basis, even to this day. 
						</p>
						<p class="mt-2">He has a keen interest in debating and loves watching news, sports and tv serials of historical importance. His favorite past-time has always been telling stories to his two daughters and now to his grandchildren. These stories would range from mythology to history to politics to on-the-spot, self cooked life dramas.  
						</p>
						<p class="mt-2">At 80 plus years of age, he is keen to adopt to the ever-changing technology , he is still learning, and his latest learning is "how to send your location" to someone on WhatsApp !!! Inspiring everyday !!!
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>









</section>



@endsection

