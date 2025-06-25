import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
  stages: [
    { duration: '30s', target: 20 }, // Montée en charge
    { duration: '1m', target: 20 },  // Charge constante
    { duration: '30s', target: 0 },  // Descente
  ],
  thresholds: {
    http_req_duration: ['p(95)<500'], // 95% des requêtes < 500ms
    http_req_failed: ['rate<0.1'],    // Taux d'échec < 10%
  },
};

const BASE_URL = 'http://localhost:8000';

export default function () {
  // Test de l'endpoint principal
  const mainResponse = http.get(`${BASE_URL}/api`);
  check(mainResponse, {
    'main endpoint status is 200': (r) => r.status === 200,
    'main endpoint response time < 200ms': (r) => r.timings.duration < 200,
  });

  // Test des endpoints API
  const apiEndpoints = [
    '/api/countries',
    '/api/guides',
    '/api/locations',
    '/api/visits',
  ];

  apiEndpoints.forEach(endpoint => {
    const response = http.get(`${BASE_URL}${endpoint}`);
    check(response, {
      [`${endpoint} status is 200`]: (r) => r.status === 200,
      [`${endpoint} response time < 300ms`]: (r) => r.timings.duration < 300,
    });
  });

  // Test d'authentification
  const authResponse = http.post(`${BASE_URL}/api/login`, JSON.stringify({
    email: 'test@example.com',
    password: 'password'
  }), {
    headers: { 'Content-Type': 'application/json' },
  });
  
  check(authResponse, {
    'auth endpoint status is 401 or 200': (r) => r.status === 401 || r.status === 200,
    'auth response time < 500ms': (r) => r.timings.duration < 500,
  });

  sleep(1);
} 