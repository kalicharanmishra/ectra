@extends('front.layouts.app')



@section('content')
<style>
	h4{
		text-transform: math-auto;
	}
</style>



			<!-- ============================================================== -->

			<section style="background-color: #FFFBEB;">
			<!-- class="all-bg" -->
			<!-- ============================ Page Title Start================================== -->

			<div class="page-title" style="margin-bottom: 0px">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">
	
							<div class="breadcrumbs-wrap">
								<nav aria-label="breadcrumb">
									<ol class="breadcrumbb">
										<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
										<li class="breadcrumb-item"><a href="{{ url('/') }}">Courses</a></li>


										<?php $parent3 = request()->category ;?>
										@if (isset(request()->category) && request()->category != '')

											<?php $parent = parentCat(request()->category); ?>

											@if(!empty($parent['parent_cat_data']))

												<?php $parent2 = parentCat(request()->category)["parent_cat_data"]["name"] ;?>

												<?php $parentparent =  parentCat($parent['parent_cat_data']['name']); ?>
												@if(!empty($parentparent['parent_cat_data']))
													
													<?php $parent1 = parentCat(parentCat(request()->category)["parent_cat_data"]["name"])["parent_cat_data"]["name"] ;?>
												
													<li class="breadcrumb-item "><a
															href="{{ url('/category?category='.$parent1) }}">{{ $parentparent['parent_cat_data']['name'] }}</a>
													</li>
												@endif

												
												<li class="breadcrumb-item"><a
														href="{{ url('/category?category='.$parent2) }}">{{ $parent['parent_cat_data']['name'] }}</a>
												</li>
											@endif

										@endif
										

										<li class="breadcrumb-item"><a style="color: #a30a0a !important"
											href="{{ url('/category?category='.$parent3) }}">{{ request()->category }}</a></li>

	
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>

			@include('front.includes.category_section')

			<!-- ============================ All Cources ================================== -->

		</section>

 @endsection

		