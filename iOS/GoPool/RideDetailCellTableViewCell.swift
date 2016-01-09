//
//  RideDetailCellTableViewCell.swift
//  GoPool
//
//  Created by Nikhil Kulkarni on 1/7/16.
//  Copyright © 2016 Nikhil Kulkarni. All rights reserved.
//

import UIKit

class RideDetailCellTableViewCell: UITableViewCell {
    
    @IBOutlet var typeLabel: UILabel!
    @IBOutlet var nameLabel: UILabel!

    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }

    override func setSelected(selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)
        
        // Configure the view for the selected state
    }

}
