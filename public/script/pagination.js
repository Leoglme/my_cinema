function newPagination(nbrPages, pageCourante, nameClass, myURL) {
    let ul = '<ul class="pagination__ordList">';
    let active;
    let leftButton = pageCourante - 1;
    let rightButton = pageCourante + 1;


    // PAGE RETOUR => affiche le bouton précédent si la page actuelle n'est pas la première
    if (pageCourante > 1) {
        ul += '<li onclick="newPagination(nbrPages,' + (pageCourante - 1) + ', nameClass, myURL)" class="page-number prev"><a href="' + myURL + (pageCourante - 1) + '" class="page__number--link"><i class="fa fa-angle-left"></i></a></li>';
    }
    // Afficher tous les Boutons si nombre de page est de 5 maxi
    if (nbrPages < 6) {
        for (let i = 1; i <= nbrPages; i++) {
            active = pageCourante === i ? "active" : "no";
            ul += '<li onclick="newPagination(nbrPages, ' + i + ', nameClass, myURL)" class="page-number ' + active + '"><a href="' + myURL + i + '" class="page__number--link">' + i + '</a></li>';
        }
    } else {
        // nombre de bouton à afficher après la page actuelle
        if (pageCourante === 1) {
            rightButton += 3;
        } else {
            rightButton += 2;
        }
        // nombre de pages à afficher après la page actuelle
        if (pageCourante === nbrPages) {
            leftButton -= 3;
        } else if (pageCourante === nbrPages - 1) {
            leftButton -= 2;
        }


        for (let i = leftButton; i <= rightButton; i++) {
            if (i === 0) {
                i += 1;
            }
            if (i > nbrPages) {
                break;
            }
            active = pageCourante === i ? "active" : "no";
            ul += '<li onclick="newPagination(nbrPages, ' + i + ', nameClass, myURL)" class="page-number ' + active + '"><a href="' + myURL + i + '" class="page__number--link">' + i + '</a></li>';
        }
    }
    // PAGE SUIVANT => Afficher le bouton Suivant uniquement si vous êtes sur une page autre que la dernière
    if (pageCourante < nbrPages) {
        ul += '<li onclick="newPagination(nbrPages, ' + (pageCourante + 1) + ', nameClass, myURL)" class="page-number next"><a href="' + myURL + (pageCourante + 1) + '" class="page__number--link"><i class="fa fa-angle-right"></i></a></li>';
    }

    ul += '</ul>';
    document.getElementsByClassName(nameClass)[0].innerHTML = ul;

    console.log(pageCourante);
}