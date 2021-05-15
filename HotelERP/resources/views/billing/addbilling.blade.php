item['name']item['name']item['name'](item, index) {
                                                    // itemName.push(item['name']);
                                                    console.log(item['name']);
                                                    $('#item').val():
                                                }
                                                
                                            }
                                        }); 
                                        
                                    }
                                    // console.log(selectedValue);
                                    // $("#name").val($(this).find("option:selected").attr("value"))
                                    });
                                </script>
                                <div class="form-group">
                                    <label>Item Name</label>
                                    <ul id="item">
                                        
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label>Order Type</label>
                                    <input class="form-control" type="text" id="order_type" name="order_type" placeholder="Enter Order Type"
                                    readonly="readonly">
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input class="form-control" type="text" id="price" name="price" placeholder="Enter Price"
                                    readonly="readonly">
                                </div>
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input class="form-control" type="text" name="discount" placeholder="Enter Discount"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>CGST</label>
                                    <input class="form-control" type="text" name="cgst" placeholder="Enter CGST"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>SGST</label>
                                    <input class="form-control" type="text" name="sgst" placeholder="Enter SGST"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input class="form-control" type="text" name="quantity" placeholder="Enter Quantity"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Taxable Amount</label>
                                    <input class="form-control" type="text" name="taxable_amount" placeholder="Enter Taxable Amount"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Payable Amount</label>
                                    <input class="form-control" type="text" name="payable_amount" placeholder="Enter Payable Amount"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Change Amount</label>
                                    <input class="form-control" type="text" name="change_amount" placeholder="Enter Change Amount"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Grand Total</label>
                                    <input class="form-control" type="text" name="grand_total" placeholder="Enter Grand Total"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Active</label>
                                
                                    <input type="checkbox" name="active" value="1">
                                </div>

                                <button type="submit" class="btn btn-primary"> Create Bill</button>
                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        
        <!-- /.col-lg-12 -->
        
    </div>
       
</div>
@include('admin.footer')    