<?php

// Test script to debug the journals.preview route
// Run this to test a specific journal UUID

require_once 'vendor/autoload.php';

echo "<h1>Journal Preview Route Test</h1>";

// You can change this UUID to test with a specific journal
$testUuid = 'your-journal-uuid-here'; // Replace with actual UUID

echo "<p>Testing route: <code>/journals/preview/{$testUuid}</code></p>";

// Test the route directly
$testUrl = url("/journals/preview/{$testUuid}");

echo "<h2>Test Links:</h2>";
echo "<ul>";
echo "<li><a href='{$testUrl}' target='_blank'>Direct Preview Link</a></li>";
echo "<li><a href='{$testUrl}' target='_blank' onclick='testPreviewAjax(); return false;'>Test AJAX Call</a></li>";
echo "</ul>";

echo "<div id='test-results'></div>";

echo "<script>
function testPreviewAjax() {
    const resultsDiv = document.getElementById('test-results');
    resultsDiv.innerHTML = '<h3>Testing AJAX Call...</h3>';
    
    fetch('{$testUrl}', {
        method: 'GET',
        headers: {
            'Accept': 'application/json, text/html',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        const contentType = response.headers.get('content-type');
        resultsDiv.innerHTML += '<p><strong>Status:</strong> ' + response.status + '</p>';
        resultsDiv.innerHTML += '<p><strong>Content-Type:</strong> ' + contentType + '</p>';
        
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(data => {
                resultsDiv.innerHTML += '<h4>JSON Response:</h4>';
                resultsDiv.innerHTML += '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
            });
        } else {
            return response.text().then(text => {
                resultsDiv.innerHTML += '<h4>HTML Response (first 500 chars):</h4>';
                resultsDiv.innerHTML += '<pre>' + text.substring(0, 500) + '...</pre>';
            });
        }
    })
    .catch(error => {
        resultsDiv.innerHTML += '<h4>Error:</h4>';
        resultsDiv.innerHTML += '<p style=\"color: red;\">' + error.message + '</p>';
    });
}
</script>";

echo "<h2>Debug Information:</h2>";
echo "<p>Current user: " . (auth()->check() ? auth()->user()->email : 'Not logged in') . "</p>";
echo "<p>User roles: " . (auth()->check() ? implode(', ', auth()->user()->getRoleNames()->toArray()) : 'None') . "</p>";

// List some journals for testing
try {
    $journals = \App\Models\Journal::take(5)->get(['id', 'uuid', 'title', 'journal_url']);
    
    echo "<h3>Available Journals for Testing:</h3>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>UUID</th><th>Title</th><th>Has Document</th><th>Test Link</th></tr>";
    
    foreach ($journals as $journal) {
        $hasDoc = !empty($journal->journal_url) ? 'Yes' : 'No';
        $testLink = route('journals.preview', $journal->uuid);
        echo "<tr>";
        echo "<td>{$journal->id}</td>";
        echo "<td>{$journal->uuid}</td>";
        echo "<td>" . substr($journal->title, 0, 30) . "...</td>";
        echo "<td>{$hasDoc}</td>";
        echo "<td><a href='{$testLink}' target='_blank'>Test</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch (Exception $e) {
    echo "<p>Error loading journals: " . $e->getMessage() . "</p>";
}
