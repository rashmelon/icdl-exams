<nav id="navbar" class="navbar navbar-expand
 navbar-light bg-light">
    <div class="nav-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top justify-content-center">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto ml-auto">
                    <li class="nav-item align-items-center d-flex">
                        <a class="nav-link" href="{{route('category')}}">Category</a>
                    </li>
                    <li class="nav-item align-items-center d-flex">
                        <a class="nav-link" href="{{route('exam')}}">Exam</a>
                    </li>
                    <li class="nav-item align-items-center d-flex">
                        <a href="{{route('home')}}"> <img draggable="false" class="logo-sm" src="{{asset('logo.png')}}" alt="Logo"></a>
                    </li>
                    <li class="nav-item align-items-center d-flex">
                        <a class="nav-link" href="{{route('instruction')}}">Instruction</a>
                    </li>
                    <li class="nav-item align-items-center d-flex">
                        <a class="nav-link" href="{{route('unassigned')}}">Unassigned</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</nav>

