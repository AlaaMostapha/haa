@extends('frontend.company.layouts.app')

@section('subtitle'){{ __('review') }}@endsection
@section('footer')@endsection
@section('content')
<div class="sign-area rating-wrap col-xs-12 vheight">
    <div class="container">
        <div class="sign-inner ccol-lg-7 col-lg-10 col-xs-12 positionCentered">
            <div class="rate-area col-xs-12">
                <div class="rate-img">
                    @if($companyTaskUserApply->user->user_personal_photo)
                    <img src="{{ $companyTaskUserApply->user->user_personal_photo }}" alt="{{ $companyTaskUserApply->user->firstName . ' ' . $companyTaskUserApply->user->lastName }}">
                    @endif
                    <img src="images/user1.png" alt="">
                </div>
                <div class="rate-title">
                    <h3> {{ __('companytask.rate user') }} <span>{{ $companyTaskUserApply->user->firstName . ' ' .  $companyTaskUserApply->user->lastName}}</span></h3>
                </div>
                <form class="dev-validate-form" method="POST" action="{{ route('company.tasks.submitReview', ['companyTaskUserApply' => $companyTaskUserApply]) }}">
                    @csrf

                    <div class="rate-stars">
                        <div class="stars form-group @error('rate') has-error @enderror">
                            <input class="star star-5" id="star-5" type="radio" value="5" name="rate[]" title="5" required  {{ is_array(old('rate')) && in_array('5', old('rate')) ? 'checked' : '' }}/>
                            <label class="star star-5" for="star-5"></label>
                            <input class="star star-4" id="star-4" type="radio"  value="4" name="rate[]" title="4" required {{ is_array(old('rate')) && in_array('4', old('rate')) ? 'checked' : '' }}/>
                            <label class="star star-4" for="star-4"></label>
                            <input class="star star-3" id="star-3" type="radio"  value="3" name="rate[]" title="3" required {{ is_array(old('rate')) && in_array('3', old('rate')) ? 'checked' : '' }}/>
                            <label class="star star-3" for="star-3"></label>
                            <input class="star star-2" id="star-2" type="radio"  value="2" name="rate[]" title="2" required {{ is_array(old('rate')) && in_array('2', old('rate')) ? 'checked' : '' }}/>
                            <label class="star star-2" for="star-2"></label>
                            <input class="star star-1" id="star-1" type="radio"  value="1" name="rate[]" title="1" required {{ is_array(old('rate')) && in_array('1', old('rate')) ? 'checked' : '' }}/>
                            <label class="star star-1" for="star-1"></label>
                            @error('rate')
                            <span class="help-block" role="alert">
                                {{ $message }}
                            </span>
                            @enderror

                        </div>
                    </div>
                    <div class="rate-form">
                        <div class="form-group @error('review') has-error @enderror">
                            <textarea class="form-control" placeholder="{{ __('companytask.Write a review') }}" name="review" required></textarea>
                            @error('review')
                            <span class="help-block" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                            <button type="submit" class="btn">{{ __('Submit') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection