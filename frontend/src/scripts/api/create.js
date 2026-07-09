export async function createUser(apiUrl, {name, age, email}) {
    //desestruturação ele da direto no lugar de fazer 
    const response = await fetch(apiUrl , {
        method: 'POST',
        headers: {'Content-Type' : 'application/json'},
        body: JSON.stringify({name, age: Number(age), email}),
    });

    const data = await response.json();

    if(!response.ok){
        throw new Error(data.error || 'Failed to create user');
    }
    return data;
}