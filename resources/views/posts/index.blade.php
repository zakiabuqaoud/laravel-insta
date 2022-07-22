<x-front-layout>

{{--
<x-alert type="danger" name="">
    <h1>My Message</h1>
    <p>Long message text</p>
</x-alert>
--}}

<x-alert />

<div class="row">
    <div class="col-lg-3 col-md-4 pd-left-none no-pd">
        <div class="main-left-sidebar no-margin">
            <div class="user-data full-width">
                <div class="user-profile">
                    <div class="username-dt">
                        <div class="usr-pic">
                            <img src="{{ Auth::user()->profile->avatar_url }}" alt="">
                        </div>
                    </div>
                    <div class="user-specs">
                        <h3>{{ Auth::user()->name }}</h3>
                        <span>{{ Auth::user()->profile->bio }}</span>
                    </div>
                </div>
                <ul class="user-fw-status">
                    <li>
                        <h4>Following</h4>
                        <span>{{ Auth::user()->followings()->count() }}</span>
                    </li>
                    <li>
                        <h4>Followers</h4>
                        <span>{{ Auth::user()->followers()->count() }}</span>
                    </li>
                    <li>
                        <a href="{{ route('profile.index', [Auth::user()->username]) }}" title="">View Profile</a>
                    </li>
                </ul>
            </div>
            <div class="suggestions full-width">
                <div class="sd-title">
                    <h3>Suggestions</h3>
                    <i class="la la-ellipsis-v"></i>
                </div>
                <div class="suggestions-list">
                    <div class="suggestion-usd">
                        <img src="images/resources/s1.png" alt="">
                        <div class="sgt-text">
                            <h4>Jessica William</h4>
                            <span>Graphic Designer</span>
                        </div>
                        <span><i class="la la-plus"></i></span>
                    </div>
                    <div class="suggestion-usd">
                        <img src="images/resources/s2.png" alt="">
                        <div class="sgt-text">
                            <h4>John Doe</h4>
                            <span>PHP Developer</span>
                        </div>
                        <span><i class="la la-plus"></i></span>
                    </div>
                    <div class="suggestion-usd">
                        <img src="images/resources/s3.png" alt="">
                        <div class="sgt-text">
                            <h4>Poonam</h4>
                            <span>Wordpress Developer</span>
                        </div>
                        <span><i class="la la-plus"></i></span>
                    </div>
                    <div class="suggestion-usd">
                        <img src="images/resources/s4.png" alt="">
                        <div class="sgt-text">
                            <h4>Bill Gates</h4>
                            <span>C & C++ Developer</span>
                        </div>
                        <span><i class="la la-plus"></i></span>
                    </div>
                    <div class="suggestion-usd">
                        <img src="images/resources/s5.png" alt="">
                        <div class="sgt-text">
                            <h4>Jessica William</h4>
                            <span>Graphic Designer</span>
                        </div>
                        <span><i class="la la-plus"></i></span>
                    </div>
                    <div class="suggestion-usd">
                        <img src="images/resources/s6.png" alt="">
                        <div class="sgt-text">
                            <h4>John Doe</h4>
                            <span>PHP Developer</span>
                        </div>
                        <span><i class="la la-plus"></i></span>
                    </div>
                    <div class="view-more">
                        <a href="#" title="">View More</a>
                    </div>
                </div>
            </div>
            <div class="tags-sec full-width">
                <ul>
                    <li><a href="#" title="">Help Center</a></li>
                    <li><a href="#" title="">About</a></li>
                    <li><a href="#" title="">Privacy Policy</a></li>
                    <li><a href="#" title="">Community Guidelines</a></li>
                    <li><a href="#" title="">Cookies Policy</a></li>
                    <li><a href="#" title="">Career</a></li>
                    <li><a href="#" title="">Language</a></li>
                    <li><a href="#" title="">Copyright Policy</a></li>
                </ul>
                <div class="cp-sec">
                    <img src="images/logo2.png" alt="">
                    <p><img src="images/cp.png" alt="">Copyright 2019</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-8 no-pd">
        <div class="main-ws-sec">
            @each('_partials.post', $posts, 'post')

        </div>
    </div>
    <div class="col-lg-3 pd-right-none no-pd">
        <div class="right-sidebar">
            <div class="widget widget-about">
                <img src="images/wd-logo.png" alt="">
                <h3>Track Time on Workwise</h3>
                <span>Pay only for the Hours worked</span>
                <div class="sign_link">
                    <h3><a href="sign-in.html" title="">Sign up</a></h3>
                    <a href="#" title="">Learn More</a>
                </div>
            </div>
            <div class="widget widget-jobs">
                <div class="sd-title">
                    <h3>Top Jobs</h3>
                    <i class="la la-ellipsis-v"></i>
                </div>
                <div class="jobs-list">
                    <div class="job-info">
                        <div class="job-details">
                            <h3>Senior Product Designer</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit..</p>
                        </div>
                        <div class="hr-rate">
                            <span>$25/hr</span>
                        </div>
                    </div>
                    <div class="job-info">
                        <div class="job-details">
                            <h3>Senior UI / UX Designer</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit..</p>
                        </div>
                        <div class="hr-rate">
                            <span>$25/hr</span>
                        </div>
                    </div>
                    <div class="job-info">
                        <div class="job-details">
                            <h3>Junior Seo Designer</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit..</p>
                        </div>
                        <div class="hr-rate">
                            <span>$25/hr</span>
                        </div>
                    </div>
                    <div class="job-info">
                        <div class="job-details">
                            <h3>Senior PHP Designer</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit..</p>
                        </div>
                        <div class="hr-rate">
                            <span>$25/hr</span>
                        </div>
                    </div>
                    <div class="job-info">
                        <div class="job-details">
                            <h3>Senior Developer Designer</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit..</p>
                        </div>
                        <div class="hr-rate">
                            <span>$25/hr</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget widget-jobs">
                <div class="sd-title">
                    <h3>Most Viewed This Week</h3>
                    <i class="la la-ellipsis-v"></i>
                </div>
                <div class="jobs-list">
                    <div class="job-info">
                        <div class="job-details">
                            <h3>Senior Product Designer</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit..</p>
                        </div>
                        <div class="hr-rate">
                            <span>$25/hr</span>
                        </div>
                    </div>
                    <div class="job-info">
                        <div class="job-details">
                            <h3>Senior UI / UX Designer</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit..</p>
                        </div>
                        <div class="hr-rate">
                            <span>$25/hr</span>
                        </div>
                    </div>
                    <div class="job-info">
                        <div class="job-details">
                            <h3>Junior Seo Designer</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit..</p>
                        </div>
                        <div class="hr-rate">
                            <span>$25/hr</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget suggestions full-width">
                <div class="sd-title">
                    <h3>Most Viewed People</h3>
                    <i class="la la-ellipsis-v"></i>
                </div>
                <div class="suggestions-list">
                    <div class="suggestion-usd">
                        <img src="images/resources/s1.png" alt="">
                        <div class="sgt-text">
                            <h4>Jessica William</h4>
                            <span>Graphic Designer</span>
                        </div>
                        <span><i class="la la-plus"></i></span>
                    </div>
                    <div class="suggestion-usd">
                        <img src="images/resources/s2.png" alt="">
                        <div class="sgt-text">
                            <h4>John Doe</h4>
                            <span>PHP Developer</span>
                        </div>
                        <span><i class="la la-plus"></i></span>
                    </div>
                    <div class="suggestion-usd">
                        <img src="images/resources/s3.png" alt="">
                        <div class="sgt-text">
                            <h4>Poonam</h4>
                            <span>Wordpress Developer</span>
                        </div>
                        <span><i class="la la-plus"></i></span>
                    </div>
                    <div class="suggestion-usd">
                        <img src="images/resources/s4.png" alt="">
                        <div class="sgt-text">
                            <h4>Bill Gates</h4>
                            <span>C &amp; C++ Developer</span>
                        </div>
                        <span><i class="la la-plus"></i></span>
                    </div>
                    <div class="suggestion-usd">
                        <img src="images/resources/s5.png" alt="">
                        <div class="sgt-text">
                            <h4>Jessica William</h4>
                            <span>Graphic Designer</span>
                        </div>
                        <span><i class="la la-plus"></i></span>
                    </div>
                    <div class="suggestion-usd">
                        <img src="images/resources/s6.png" alt="">
                        <div class="sgt-text">
                            <h4>John Doe</h4>
                            <span>PHP Developer</span>
                        </div>
                        <span><i class="la la-plus"></i></span>
                    </div>
                    <div class="view-more">
                        <a href="#" title="">View More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</x-front-layout>