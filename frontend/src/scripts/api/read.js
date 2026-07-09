export async function getUsers(apiUrl) {
    const response = await fetch(apiUrl);
    const data = await response.json()

    if(!response.ok) {
        throw new Error(data.error || 'failed to fetch users')
    }
    return data.users;
}
//função assincrona  quando precisa de algo a mais 
//quando demora por pegar de outro lugar exmplo
//esse é assincrona pois pega da apiUrl e da função get users

//sincrona é quando acontece tudo sem espera
//exemplo é uma função de somar que retonra o valor e a outra parte 
//apenas mostra o valor