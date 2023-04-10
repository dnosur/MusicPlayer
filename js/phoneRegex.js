function onChange(value){
    document.getElementById('submit').style.display =  /^\+380\d{3}\d{2}\d{2}\d{2}$/.exec(value.value) ? '' : 'none';
}