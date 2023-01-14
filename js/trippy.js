{
    let head, content, allowedAmount, currentAmount,$content;

    const trip = ()=>{
        $content.classList.add('trippy');
    }
    const fetchData = ()=>{
        streak = document.getElementById("streak").textContent;
        streak= parseInt(streak);
        console.log(streak);
        allowedAmount = 10-(streak+1);
        currentAmount= parseInt(document.querySelector('.coffee__consumed--add p').textContent); 
    }

    const init =  ()=>{
        head= document.querySelector('.preview__head');
        $content= document.querySelector('.content');
        console.log($content);
        fetchData();
        if(currentAmount > allowedAmount){
            trip();
        }
    }
    init();
}