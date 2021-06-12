class CreateUsers < ActiveRecord::Migration[6.1]
  def change
    create_table :users do |t|
      t.string :name
      t.string :ssn
      t.string :email
      t.string :password_digest
      t.integer :kind

      t.timestamps
    end
  end
end
