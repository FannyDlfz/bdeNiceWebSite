let isOpened = false;

function toggleNav()
{
    isOpened ? closeNav() : openNav();
}

function openNav()
{
    isOpened = true;
    document.getElementById("sidenav").style.left = "0";
    document.getElementById("side-menu").style.left = "500px";
}

function closeNav()
{
    isOpened = false;
    document.getElementById("sidenav").style.left = "-500px";
    document.getElementById("side-menu").style.left = "0";
}

