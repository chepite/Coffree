{
  //test apiConsumation
  const $recipeId= document.getElementById("recipeId");
  //end test apiConsumation
  let index;
  // let recipesLength;
  let splide, recipesdata, data;
  // const loadRecipes
  // const splideActive=()=>{

  //     splide.o.style.transform= "scale(1.25)";
  // }

  const fillList = (recipes) => {
    const $recipes = document.querySelector(".splide__list");
    $recipes.innerHTML = recipes
      .map((recipe) => {
        return `
            <li class="splide__slide">
            <p class="indicator">${recipe["name"]}</p>
            <div class="splide__slide__container">
                <img class="${recipe["name"].replace(
                  " ",
                  ""
                )}" src="assets/recipes/${recipe["name"]}.png">
                <div class="item__overlay">
                    <h2 class="item__overlay--title">${recipe["name"]}</h2>
                    <p class="item__overlay--desc">${recipe["description"]}</p>
                </div>
            </div>
        </li>`;
      })
      .join("");
  };

  const recipes = async () => {
    const url = "index.php?page=breweryApi";
    const response = await fetch(url);
    recipesdata = await response.json();
    fillList(recipesdata);
    data= recipesdata;
    recipesLenght = recipesdata.lenght;
  };

  // const buttons = async() => {
  //   index = 1;
  //   const prev = document.querySelector(".splide__arrow--prev");
  //   prev.addEventListener("click", function () {
  //     if (index != 0) {
  //       index--;
  //        details(recipesdata);
  //     }
  //     console.log(index);
  //   });
  //   const next = document.querySelector(".splide__arrow--next");
  //   next.addEventListener("click", function () {
  //     if (index != recipesLength) {
  //       index++;
  //         details(recipesdata);
  //     }
  //     console.log(index);
  //   });
  // };

  const details = (recipes) => {
    // const $active = document.querySelector(
    //   ".splide__list .is-active .indicator"
    // ).textContent;
    // index= 1;
    // const $items= document.querySelectorAll('.splide__slide .indicator');
    // let $test= $items[index].innerText;
    
    // console.log($items[0].innerText.toString());
    let recipe= recipes[1];
    
    recipe = recipes.filter(function (entry) {
      // console.log(entry.name);
      return entry["id"]=== index;
    });

    //passing data to consumationApi
    $recipeId.setAttribute('value', recipe[0].id);
    //end passing data to consumationApi
    
    // console.log(recipe);
   
    const ingredients = recipe[0].ingredients.split(",").map(
      (element) => `<li class="details__list--item">${element}</li>`
    ).join("");
    const instructions = recipe[0].instructions.split(";").map(
      (element) => `<li class="details__steps--step">${element}</li>`
    ).join("");
    const details = document.querySelector(".details");
    details.innerHTML = `
    <div class="details__image">
      <img src="assets/recipes/${recipe[0].name}.png">
    </div>
    <div class="details__info">
        <h2 class="details__title">${recipe[0].name}</h2>
    <ul class="details__list">${ingredients}</ul>
    <ul class="details__steps">
        <li class="details__steps--step"></li>
      ${instructions}
    </ul>
  </div>
    `;
  };

  const init = async () => {
    //test value voor php consumation
    
    //end test value voor php consumation
    document.documentElement.classList.add("has-js");
    card = document.querySelector(".splide__slide");
    await recipes();
     splide = new Splide(".splide", {
      pagination: false,
      focus: 2,
      perPage: 2,
      trimSpace: true,
      focus: "center",
      start: 1,
      width: "60rem",
      gap: "3em",
      rewind: true,
      //"focus":"center", "start":"1", "width":"60rem","gap":"3rem;"
    })

    splide.on('mounted', function(){
      index= 2;
      details(data);
    })
    splide.mount();
    splide.on('moved', function(newIndex){
      index= newIndex+1;
      details(data);
      // console.log('index', index)
    });
    // console.log('index', index)
    
    //details(recipesdata);
    console.log("buttons()");
    buttons();

    //card.addEventListener('click', showInfo)
  };
  init();
}















/*
{
  let index;
  let recipesLength;
  let recipesArray;
  let splide, recipesdata, card;
  // const loadRecipes
  // const splideActive=()=>{

  //     splide.o.style.transform= "scale(1.25)";
  // }

  const fillList = (recipes) => {
    const $recipes = document.querySelector(".splide__list");
    $recipes.innerHTML = recipes
      .map((recipe) => {
        return `
            <li class="splide__slide">
            <p class="indicator">${recipe["name"]}</p>
            <div class="splide__slide__container">
                <img class="${recipe["name"].replace(
                  " ",
                  ""
                )}" src="assets/recipes/${recipe["name"]}.png">
                <div class="item__overlay">
                    <h2 class="item__overlay--title">${recipe["name"]}</h2>
                    <p class="item__overlay--desc">${recipe["description"]}</p>
                </div>
            </div>
        </li>`;
      })
      .join("");
  };

  const recipes = async () => {
    const url = "index.php?page=breweryApi";
    const response = await fetch(url);
    recipesdata = await response.json();
    fillList(recipesdata);

    recipesLenght = recipesdata.lenght;
  };

  const buttons = async() => {
    index = 1;
    const prev = document.querySelector(".splide__arrow--prev");
    prev.addEventListener("click", function () {
      if (index != 0) {
        index--;
         details(recipesdata);
      }
      console.log(index);
    });
    const next = document.querySelector(".splide__arrow--next");
    next.addEventListener("click", function () {
      if (index != recipesLength) {
        index++;
          details(recipesdata);
      }
      console.log(index);
    });
  };

  const details = (recipes) => {
    // const $active = document.querySelector(
    //   ".splide__list .is-active .indicator"
    // ).textContent;
    // index= 1;
    // const $items= document.querySelectorAll('.splide__slide .indicator');
    // let $test= $items[index].innerText;
    
    // console.log($items[0].innerText.toString());
   
    // let recipe = recipes.filter(function (entry) {
    //   console.log(entry.name);
    //   return entry.name === $test;
    // });
    
    console.log(recipe);

    const ingredients = recipe[0].ingredients.split(",").map(
      (element) => `<li class="details__list--item">${element}</li>`
    ).join("");
    const details = document.querySelector(".details");
    details.innerHTML = `
    <div class="details__image">
      <img src="assets/recipes/${recipe[0].name}.png">
    </div>
    <div class="details__info">
        <h2 class="details__title">${recipe[0].name}</h2>
    <ul class="details__list">${ingredients}</ul>
    <ul class="details__steps">
        <li class="details__steps--step"></li>
    </ul>
  </div>
    `;
  };

  const init = async () => {
    document.documentElement.classList.add("has-js");
    
    card = document.querySelector(".splide__slide");
    await recipes();
    let secondaySlider = new Splide(".splide", {
      pagination: false,
      focus: 2,
      perPage: 2,
      trimSpace: true,
      focus: "center",
      start: 1,
      width: "60rem",
      gap: "3em",
      //"focus":"center", "start":"1", "width":"60rem","gap":"3rem;"
    }).mount();
    
    
    details(recipesdata);
    console.log("buttons()");
    buttons();

    //card.addEventListener('click', showInfo)
  };
  init();
}

*/
