class CreateTransactions < ActiveRecord::Migration[6.1]
  def change
    create_table :transactions do |t|
      t.integer :senderId
      t.integer :receiverId
      t.float :value

      t.timestamps
    end
  end
end
