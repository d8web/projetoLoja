let cartNumberInput = document.getElementById("numbercart")
let makePurchaseButton = document.getElementById("makePurchase")

cartNumberInput.addEventListener("keyup", () => {
    if(cartNumberInput.value.length === 6) {
        PagSeguroDirectPayment.getBrand({
            cardBin: cartNumberInput.value,
            success: (res) => {
                window.cardBrand = res.brand.name
                let cvvLimit = res.brand.cvvSize
                // document.getElementById("cvv").setAttribute("max", cvvLimit)

                PagSeguroDirectPayment.getInstallments({
                    amount: document.getElementById("total").value,
                    brand: window.cardBrand,
                    // maxInstallmentNoInterest: 10,
                    success: (res) => {
                        if(!res.error) {

                            let parc = res.installments[window.cardBrand]
                            
                            let html = "";
                            for(let i in parc) {
                                let optionValue = `${parc[i].quantity};${parc[i].installmentAmount};`
                                if(parc[i].interestFree) {
                                    optionValue += "true"
                                } else {
                                    optionValue += "false"
                                }
                                html += `<option value='${optionValue}'>
                                    ${parc[i].quantity}x de R$ ${parc[i].installmentAmount}
                                </option>`
                            }

                            document.getElementById("parc").innerHTML = html
                        }
                    },
                    error: (res) => {

                    },
                    complete: (res) => {}
                })
            },
            error: (res) => {

            },
            complete: (res) => {}
        })
    }
})

makePurchaseButton.addEventListener("click", (e) => {
    e.preventDefault();

    let id = PagSeguroDirectPayment.getSenderHash()

    let name = document.getElementById("name").value
    let cpf = document.getElementById("cpf").value
    let phone = document.getElementById("phone").value
    let email = document.getElementById("email").value
    let password = document.getElementById("password").value

    let cep = document.getElementById("cep").value
    let address = document.getElementById("address").value
    let number = document.getElementById("number").value
    let complement = document.getElementById("complement").value
    let district = document.getElementById("district").value
    let city = document.getElementById("city").value
    let state = document.getElementById("state").value

    let cardTitular = document.getElementById("cartTitular").value
    let cpfTitular = document.getElementById("cpfTitular").value
    let cardNumber = document.getElementById("numbercart").value
    let cvv = document.getElementById("cvv").value
    let month = document.getElementById("month_expiration").value
    let year = document.getElementById("year_expiration").value

    let parc = document.getElementById("parc").value

    if(cardNumber !== "" && cvv !== "" && month !== "" && year !== "") {
        PagSeguroDirectPayment.createCardToken({
            cardNumber: cardNumber,
            brand: window.cardBrand,
            cvv: cvv,
            expirationMonth: month,
            expirationYear: year,
            success: (res) => {
                window.cardToken = res.card.token

                // Finalizar pagamento
                fetch("http://localhost/loja/public/pagseguro/checkout", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id,
                        name,
                        cpf,
                        phone,
                        email,
                        password,
                        cep,
                        address,
                        number,
                        complement,
                        district,
                        city,
                        state,
                        cardTitular,
                        cpfTitular,
                        cardNumber,
                        cvv,
                        month,
                        year,
                        cardToken: window.cardToken,
                        parc,
                    })
                }).then(res => {
                    return res.json()
                }).then(json => {
                    if(json.error) {
                        alert(json.message)
                    } else {
                        window.location.href = "http://localhost/loja/public/pagseguro/thanks"
                    }
                }).catch(err => {
                    console.log("Ocorreu um erro: "+ err)
                })
            },
            error: (res) => {
                console.log(res)
            },
            complete: (res) => {}
        })   
    }
})