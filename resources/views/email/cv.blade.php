<style type="text/css" media="all">

@import url('https://fonts.googleapis.com/css?family=Montserrat:500&display=swap');

.container {
    max-width: 1000px;
    width: 100%;
    margin: 0 auto;
    font-family: 'Montserrat', sans-serif;
    border-radius: 10px;
}
.row {
    display:table;
}
.content-left {
    vertical-align: top;
    display:table-cell;
    width: 30%;
    padding: 20px 30px;
    color: lightgray;
    background-color: darkslategrey;
}
.content-right {
    vertical-align: top;
    display:table-cell;
    width: 70%;
    padding: 20px 30px;
    background-color: ivory;
}
.image-wrapper {
    margin: 10px 0 20px;
}
.image {
    background-image: url('https://images.pexels.com/photos/67636/rose-blue-flower-rose-blooms-67636.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500');
    width:150px;
    height: 150px;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 10px;
}
.section-about {
    font-size: 18px;
}
.section-name {
    margin-bottom: 40px;
}
.text-lg {
    font-size: 20px;
    margin-bottom: 10px;
}
.text-base {
    font-size: 18px;
    margin-bottom: 15px;
}
.text-small {
    font-size: 16px;
}
.underline {
  border-bottom: 2px solid lightgray;
}
.underline-black {
    border-bottom: 2px solid black;
}
.italic {
    font-style: italic;
}
</style>

<div class="container">
    <div class="row">
        <span class="content-left">
            @if($profile->image)
            <div class="image-wrapper">
                <div class="image" style=""></div>
            </div>
            @endif
            <div class="section-about">
                <h3 class="underline">About Me</h3>
                {{$profile->cv->description}}
            </div>
            <div class="section-contact">
                <h3 class="underline">Contact</h3>
                <div class="text-base">{{$profile->phone}}</div>
                <div class="text-base">{{$profile->email}}</div>
            </div>
            <div class="section-skill">
                <h3 class="underline">Skills</h3>
                @foreach ($profile->cv->skills as $skill)
                    <div>
                        {{$skill->name}}
                    </div>
                @endforeach
            </div>
            <div class="language-skill">
                <h3 class="underline">Languages</h3>
                @foreach ($profile->cv->languages as $language)
                    <div>
                        {{$language->name}}
                    </div>
                @endforeach
            </div>
        </span>
        <span class="content-right">
            <div class="section-name">
            <h1>{{$profile->first_name}} {{$profile->last_name}}</h1>
            </div>
            <div class="section-experience">
                <h2 class="underline-black">Work Experience</h2>
                @foreach ($profile->cv->workExperiences as $experience)
                <div>
                    <div class="text-lg">
                        {{$experience->company}}
                        
                        <span class="text-small">({{date('M Y', strtotime($experience->start_date))}}</span>-

                        @if($experience->end_date)

                        <span class="text-small">{{date('M Y', strtotime($experience->end_date))}})</span>

                        @endif
                    </div>
                    <div class="text-base italic">{{$experience->title}}</div>
                    <div>{{$experience->description}}</div>
                </div>
                @endforeach
            </div>
            <div class="section-education">
                <h2 class="underline-black">Education</h2>
                <div>
                    <div class="text-lg">
                        SALA - 
                        <span class="text-base italic">{{$profile->department_name}}</span>
                    </div>
                </div>
            </div>
        </span>
    </div>
</div>