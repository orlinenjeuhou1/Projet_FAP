describe('Admin Interface E2E Tests', () => {
  beforeEach(() => {
    cy.visit('http://localhost:8000/admin')
  })

  it('should load the admin dashboard', () => {
    cy.get('h1').should('contain', 'Admin')
  })

  it('should display navigation menu', () => {
    cy.get('nav').should('be.visible')
  })

  it('should show statistics', () => {
    cy.get('.statistics').should('be.visible')
  })

  it('should allow user management', () => {
    cy.get('[data-testid="users-link"]').click()
    cy.url().should('include', '/admin/users')
  })

  it('should allow visit management', () => {
    cy.get('[data-testid="visits-link"]').click()
    cy.url().should('include', '/admin/visits')
  })

  it('should display data tables', () => {
    cy.get('table').should('be.visible')
  })

  it('should handle form submissions', () => {
    cy.get('[data-testid="add-user-btn"]').click()
    cy.get('form').should('be.visible')
  })
}) 