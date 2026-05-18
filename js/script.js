// Lógica de Drag and Drop para o Kanban

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev, id) {
    ev.dataTransfer.setData("taskId", id);
}

function drop(ev, novoStatus) {
    ev.preventDefault();
    const taskId = ev.dataTransfer.getData("taskId");
    const cardElement = document.getElementById('task-' + taskId);
    
    if (!cardElement) return;

    // Tenta encontrar o container da coluna destino
    let currentTarget = ev.target;
    while (!currentTarget.classList.contains('column') && currentTarget.tagName !== 'BODY') {
        currentTarget = currentTarget.parentElement;
    }
    
    const cardsList = currentTarget.querySelector('.cards-list');
    
    if (cardsList) {
        cardsList.appendChild(cardElement);
        
        // Chamada Assíncrona para atualizar BD no PHP
        atualizarStatusBackend(taskId, novoStatus);
        
        if (novoStatus === 'concluído') {
            dispararConfete();
        }
    }
}

function atualizarStatusBackend(id, status) {
    fetch('update_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: id, status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.sucesso) {
            showToast('Erro ao atualizar status: ' + (data.msg || ''), 'error');
            setTimeout(() => window.location.reload(), 1500); // Reverter erro
        } else {
            showToast('Status atualizado com sucesso!', 'success');
        }
    })
    .catch((error) => {
        console.error('Erro:', error);
        showToast('Erro de comunicação com o servidor.', 'error');
    });
}

// ============================================
// UX & Notificações (Toasts e Efeitos)
// ============================================

function showToast(message, type = 'success') {
    let container = document.getElementById('toast-container');
    if(!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        document.body.appendChild(container);
    }
    
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    toast.innerHTML = `<i class="fas ${icon}"></i> <span>${message}</span>`;
    
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('fade-out');
        setTimeout(() => toast.remove(), 400);
    }, 3000);
}

function dispararConfete() {
    if (typeof confetti === 'function') {
        confetti({
            particleCount: 120,
            spread: 80,
            origin: { y: 0.6 },
            colors: ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6']
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const msg = params.get('msg');
    const para = params.get('para');
    
    if (msg) {
        const messages = {
            'usuario_cadastrado': 'Usuário cadastrado com sucesso!',
            'usuario_excluido': 'Usuário removido do sistema.',
            'tarefa_salva': 'Tarefa salva com sucesso!',
            'tarefa_excluida': 'Tarefa excluída definitivamente.',
            'tarefa_movida': 'Status da tarefa atualizado!'
        };
        
        if (messages[msg]) {
            showToast(messages[msg], 'success');
        }
        
        if (msg === 'tarefa_movida' && para === 'concluído') {
            dispararConfete();
        }
        
        // Remove os parâmetros da URL pra não repetir no F5
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});
