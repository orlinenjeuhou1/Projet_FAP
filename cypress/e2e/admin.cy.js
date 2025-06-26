describe('Admin login', () => {
  it('should display login page', () => {
    cy.visit('http://localhost:8000/admin');
    cy.contains('Connexion');
  });
}); 