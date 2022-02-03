export const isLogged = () => {
    return !!localStorage.getItem('jwt');
}