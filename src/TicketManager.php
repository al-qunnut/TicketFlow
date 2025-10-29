<?php

class TicketManager {
    private $dataFile;
    
    public function __construct($dataFile = null) {
        $this->dataFile = $dataFile ?? __DIR__ . '/../data/tickets.json';
        $this->ensureDataFile();
    }
    
    private function ensureDataFile() {
        if (!file_exists($this->dataFile)) {
            file_put_contents($this->dataFile, json_encode([]));
        }
    }
    
    private function readData() {
        $content = file_get_contents($this->dataFile);
        return json_decode($content, true) ?? [];
    }
    
    private function writeData($data) {
        file_put_contents($this->dataFile, json_encode($data, JSON_PRETTY_PRINT));
    }
    
    public function getAll() {
        return $this->readData();
    }
    
    public function getById($id) {
        $tickets = $this->readData();
        foreach ($tickets as $ticket) {
            if ($ticket['id'] === $id) {
                return $ticket;
            }
        }
        return null;
    }
    
    public function create($data) {
        $errors = $this->validate($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        
        $tickets = $this->readData();
        $ticket = [
            'id' => $this->generateId(),
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'status' => $data['status'],
            'priority' => $data['priority'] ?? 'medium',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        
        $tickets[] = $ticket;
        $this->writeData($tickets);
        
        return ['success' => true, 'ticket' => $ticket];
    }
    
    public function update($id, $data) {
        $errors = $this->validate($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        
        $tickets = $this->readData();
        $updated = false;
        
        foreach ($tickets as &$ticket) {
            if ($ticket['id'] === $id) {
                $ticket['title'] = $data['title'];
                $ticket['description'] = $data['description'] ?? '';
                $ticket['status'] = $data['status'];
                $ticket['priority'] = $data['priority'] ?? 'medium';
                $ticket['updated_at'] = date('Y-m-d H:i:s');
                $updated = true;
                break;
            }
        }
        
        if ($updated) {
            $this->writeData($tickets);
            return ['success' => true, 'ticket' => $ticket];
        }
        
        return ['success' => false, 'errors' => ['Ticket not found']];
    }
    
    public function delete($id) {
        $tickets = $this->readData();
        $filtered = array_filter($tickets, function($ticket) use ($id) {
            return $ticket['id'] !== $id;
        });
        
        if (count($filtered) < count($tickets)) {
            $this->writeData(array_values($filtered));
            return ['success' => true];
        }
        
        return ['success' => false, 'errors' => ['Ticket not found']];
    }
    
    public function getStats() {
        $tickets = $this->readData();
        $total = count($tickets);
        $open = 0;
        $inProgress = 0;
        $closed = 0;
        
        foreach ($tickets as $ticket) {
            switch ($ticket['status']) {
                case 'open':
                    $open++;
                    break;
                case 'in_progress':
                    $inProgress++;
                    break;
                case 'closed':
                    $closed++;
                    break;
            }
        }
        
        return [
            'total' => $total,
            'open' => $open,
            'in_progress' => $inProgress,
            'closed' => $closed,
            'resolved' => $closed
        ];
    }
    
    private function validate($data) {
        $errors = [];
        
        // Title validation
        if (empty($data['title'])) {
            $errors['title'] = 'Title is required';
        } elseif (strlen($data['title']) < 3) {
            $errors['title'] = 'Title must be at least 3 characters long';
        } elseif (strlen($data['title']) > 200) {
            $errors['title'] = 'Title must not exceed 200 characters';
        }
        
        // Status validation
        if (empty($data['status'])) {
            $errors['status'] = 'Status is required';
        } elseif (!in_array($data['status'], ['open', 'in_progress', 'closed'])) {
            $errors['status'] = 'Status must be one of: open, in_progress, closed';
        }
        
        // Description validation (optional but check length if provided)
        if (isset($data['description']) && strlen($data['description']) > 1000) {
            $errors['description'] = 'Description must not exceed 1000 characters';
        }
        
        // Priority validation (optional)
        if (isset($data['priority']) && !in_array($data['priority'], ['low', 'medium', 'high'])) {
            $errors['priority'] = 'Priority must be one of: low, medium, high';
        }
        
        return $errors;
    }
    
    private function generateId() {
        return uniqid('ticket_', true);
    }
}
