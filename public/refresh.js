


window.onload = () => {
    let endpoints = 'api';        
    requestAJAX("POST", endpoints);
}

// setInterval(() => {     
//     let endpoints = 'applications/'
//     requestAJAX("POST", endpoints);
// }, 15000); //30000

const requestAJAX = (method, endpoints) => {
    
    let url = `${window.location.href.slice(0, -13)}${endpoints}`;

    let xhr = new XMLHttpRequest();

    if (!xhr) {
        console.log ('XMLHTTP');
        return false;
    }
    
    xhr.open(method, url, true);
    
    xhr.setRequestHeader("X-Requested-With","XMLHttpRequest");
    
    xhr.onreadystatechange = () => { 
                
        if (xhr.readyState == 4) {
            if (xhr.status == 200) { 

                if (endpoints === 'api') {

                    let expired = eval("(" + xhr.responseText + ")"); 
                
                    Object.entries(expired).map((val) => {

                        if (!this[val[0]].style.color) {
                            console.log(this[val[0]].style.color = val[1]);                        
                        } else if (this[val[0]].style.color != val[1]) {
                            this[val[0]].style.color = val[1];
                        }

                    })

                }
                
                if (endpoints === 'applications/') {
                    
                    console.log(eval("(" + xhr.responseText + ")"));
                    
                }

            } else {

                console.log('Error');

            }
        }
    };    
    xhr.send();

}
