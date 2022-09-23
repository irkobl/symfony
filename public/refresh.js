
let url = `${window.location.href.slice(0, -13)}api`;
setInterval(() => {
    let xhr = new XMLHttpRequest();

    if (!xhr) {
        console.log ('XMLHTTP');
        return false;
    }
    
    xhr.open("POST", url, true);
    
    xhr.setRequestHeader("X-Requested-With","XMLHttpRequest");
    
    xhr.onreadystatechange = () => { 
                
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {                
                let expired = eval("(" + xhr.responseText + ")");
                
                Object.entries(expired).map((val) => {
                    if (!this[val[0]].style.color) {
                        console.log(this[val[0]].style.color = val[1]);                        
                    } else if (this[val[0]].style.color != val[1]) {
                        this[val[0]].style.color = val[1];
                    }                    
                })                

            } else {
                console.log('Error');
            }
        }
    };    
    xhr.send(); 

}, 1800000);