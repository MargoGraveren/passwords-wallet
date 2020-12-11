<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/home">Simple Passwords Wallet</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/home">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/passwords/create">Add Password</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/reset">Change Main Password</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/history">Login History</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/blocked">Blocked IPs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/modifymode">Modify Mode</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/logout">Log Out</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <span>Welcome, {{ Auth::user()->name }}!</span>
        </form>
    </div>
</nav>
