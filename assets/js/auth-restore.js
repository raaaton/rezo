async function restoreAuthToken() {
    const response = await fetch('/api/check-auth.php', { credentials: 'include' });
  
    if (response.status === 401) {
        const token = localStorage.getItem('auth_token');
        if (!token) return;

        const restoreResponse = await fetch('/pages/restore-cookie.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            credentials: 'include',
            body: JSON.stringify({ token })
        });

        if (restoreResponse.ok) {
            location.reload();
        } else {
            localStorage.removeItem('auth_token');
        }
    }
}

restoreAuthToken();
