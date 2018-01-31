<?php

echo
'<nav class="navbar navbar-dark <!--navbar-expand-lg--> bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/clockapp/">CLOCK APP</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/clockapp/clockin">Clock In</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/clockapp/clockout">Clock Out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/clockapp/manage">Manage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/clockapp/admin/bydate">View By Date</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/clockapp/admin/byemp">View By Employee</a>
                    </li>';
                        if(isset($_COOKIE['login'])){
                            if($_COOKIE['login'] == true){
                                echo '<li class="nav-item">
                        <a class="nav-link" href="/clockapp/admin/addemp">Add Employee</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/clockapp/admin/removeemp">Remove Employee</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/clockapp/selectstore">Select Store</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/clockapp/logout">Sign Out</a>
                    </li>';
                            }
                        }
                        else{
                            echo '<li class="nav-item">
                        <a class="nav-link" href="/clockapp/login">Sign In</a>
                    </li>';
                        }

                echo '</ul>
             </div>
        </div>
    </nav>';

