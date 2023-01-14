{

    let streak;
    //get data from detox api and display it accordingly to design
    //--> todays streak in middle, previous left, nex right

    const detox = async ()=>{
        const url ="index.php?page=detoxApi";
        const response= await fetch(url);
        const data = await response.json();
        getProgress(data);
    }
    const highlight = ()=>{
        //highlight the current day in progress
        const $items = document.querySelectorAll(".progressList__item");
        console.log($items);
        $items.forEach(element=>{
            if(element.getAttribute("id")== streak){
                element.classList.add("highlight");
            }
        });
    }
    const fillProgress=(data)=>{
        const list= document.querySelector(".progressList");
        list.innerHTML= data.map(element => {
                    return `
                    <li id="${element["day"]}" class="progressList__item">
                    <img src="assets/profile/${element["typeReward"]}/${element["asset"]}.png" class="progressList__item--image">
                    <div class="progressList__item--info">
                    <h2 class="progressList__item--title">${element["title"]}</h2>
                    <p class="progressList__item--desc">${element["info"]}</p>
                    </div>
                    </li>
                    `
        }).join("");
        
        highlight();
    }
    const fillOther = (data)=>{
        const $recomAmount= document.querySelector(".coffee__recommended--amount");
        $recomAmount.textContent = `${data["targetAmount"]} cups`;
    }
    const getProgress = (data)=>{
        let dataArray= Array.from(data);
        let display;
         streak= parseInt(document.getElementById("streak").textContent);
         
         let dayData= data[streak];
        console.log(dayData);
        console.log(streak);
        if(streak == 0){
            display= dataArray.slice(0,3);
            console.log("streak0")
        }
        if((streak -1) >= 0 && (streak +1) <= dataArray.length){
           display=  dataArray.slice(streak-1, streak+2);
           console.log("streak1")
        }
        else if((streak+1) > dataArray.length){
           display= dataArray.slice(streak-2, dataArray.length);
           console.log("streak2")
        }
        // else if(streak == 10){
        //     display= dataArray.slice(streak-2, dataArray.length);
        //     console.log("streak1")
        //  }
        // else{
        //     display=  dataArray.slice(streak-1, streak+1);
        //     console.log("streak2")
        //  }
        console.log(dataArray.length);
        console.log(display);
        fillProgress(display);   
        fillOther(dayData);
    }
    const init = async ()=>{
        await detox();

    }
    init();
}