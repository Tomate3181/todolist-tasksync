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
    const containerOrigem = document.getElementById('task-' + taskId).parentElement;
    
    // Tenta encontrar o container da coluna destino
    let currentTarget = ev.target;
    while (!currentTarget.classList.contains('column') && currentTarget.tagName !== 'BODY') {
        currentTarget = currentTarget.parentElement;
    }
    
    const cardsList = currentTarget.querySelector('.cards-list');
    const cardElement = document.getElementById('task-' + taskId);
    
    if (cardsList && cardElement) {
        cardsList.appendChild(cardElement);
        
        // Chamada Assíncrona para atualizar BD no PHP
        atualizarStatusBackend(taskId, novoStatus);
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
            alert('Erro ao atualizar status: ' + data.msg);
            // Poderia reverter a DOM aqui em caso de falha para garantir consistência
        }
    })
    .catch((error) => {
        console.error('Erro:', error);
    });
}
