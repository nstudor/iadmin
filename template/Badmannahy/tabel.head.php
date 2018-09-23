<style>
input[type=radio],
input[type=checkbox] {
    display: none;
}

input[type="checkbox"] + label {
    font-family: 'Font Awesome 5 Free';
}

input[type="checkbox"] + label::before {
    content: "\f0c8";
}

input[type="checkbox"]:checked + label::before {
    content: "\f14a";
}

#contextMenu {
    position: fixed;    
}

</style>